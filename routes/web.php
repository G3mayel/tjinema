<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\TheaterController;
use App\Http\Controllers\Admin\BeverageController;
use App\Http\Controllers\Admin\ShowtimeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/movies');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/movies/{movie}/watchlist', [MovieController::class, 'toggleWatchlist'])->name('movies.watchlist.toggle');

    Route::get('/activity', [UserActivityController::class, 'index'])->name('activity.index');

    Route::get('/movies/{movie}/book', [BookingController::class, 'selectDate'])->name('bookings.date');
    Route::get('/movies/{movie}/book/theater/{date}', [BookingController::class, 'selectTheater'])->name('bookings.theater');
    Route::get('/movies/{movie}/book/seats', [BookingController::class, 'selectSeats'])->name('bookings.seats');
    Route::match(['GET', 'POST'], '/bookings/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/bookings/process-payment', [BookingController::class, 'processPayment'])->name('bookings.process-payment');
    Route::get('/bookings/{booking}/ticket', [BookingController::class, 'getTicket'])->name('bookings.ticket');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/receipt', [BookingController::class, 'receipt'])->name('bookings.receipt');
    Route::get('/bookings/{booking}/download-ticket', [BookingController::class, 'downloadTicket'])->name('bookings.download-ticket');

    // AJAX routes
    Route::post('/bookings/check-seat-availability', [BookingController::class, 'checkSeatAvailability'])->name('bookings.check-availability');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('movies', AdminMovieController::class)->except(['show']);
    Route::resource('theaters', TheaterController::class)->except(['show']);
    Route::resource('beverages', BeverageController::class)->except(['show']);
    Route::resource('showtimes', ShowtimeController::class)->except(['show']);
});
