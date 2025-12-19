<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('bookings', 'booking_number')) {
                $table->string('booking_number')->unique();
            }
            if (!Schema::hasColumn('bookings', 'show_date')) {
                $table->date('show_date');
            }
            if (!Schema::hasColumn('bookings', 'showtime')) {
                $table->time('showtime');
            }
            if (!Schema::hasColumn('bookings', 'beverages')) {
                $table->json('beverages')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('confirmed');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_number', 'show_date', 'showtime', 'beverages', 'status']);
        });
    }
};
