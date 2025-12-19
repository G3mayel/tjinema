{{-- resources/views/bookings/payment-error.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        Payment Error
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5>{{ $message ?? 'An unexpected error occurred. Please try again.' }}</h5>
                    </div>

                    @if(config('app.debug') && isset($debug_info) && $debug_info)
                        <div class="card mt-4">
                            <div class="card-header bg-warning">
                                <h6 class="mb-0">Debug Information (Development Mode)</h6>
                            </div>
                            <div class="card-body">
                                <pre class="bg-light p-3 rounded">{{ print_r($debug_info, true) }}</pre>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <h6>What you can do:</h6>
                        <ul>
                            <li>Go back to movies and start the booking process again</li>
                            <li>Check if the movie showtime is still available</li>
                            <li>Make sure your browser has JavaScript enabled</li>
                            <li>Try refreshing the page</li>
                        </ul>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('movies.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Back to Movies
                        </a>

                        @if(request()->headers->get('referer'))
                            <a href="{{ request()->headers->get('referer') }}" class="btn btn-secondary">
                                <i class="fas fa-undo"></i>
                                Go Back
                            </a>
                        @endif

                        <button onclick="location.reload()" class="btn btn-outline-primary">
                            <i class="fas fa-refresh"></i>
                            Refresh Page
                        </button>
                    </div>
                </div>
            </div>

            {{-- Additional Help Section --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Need Help?</h6>
                </div>
                <div class="card-body">
                    <p>If you continue to experience problems:</p>
                    <ul>
                        <li>Contact our support team</li>
                        <li>Try using a different browser</li>
                        <li>Clear your browser cache and cookies</li>
                        <li>Check your internet connection</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card.border-danger {
    border-width: 2px;
}

.alert-danger {
    border-left: 4px solid #dc3545;
}

pre {
    max-height: 300px;
    overflow-y: auto;
    font-size: 0.875rem;
}

.btn {
    min-width: 120px;
}

.d-flex.gap-2 > * {
    margin-right: 0.5rem;
}

.d-flex.gap-2 > *:last-child {
    margin-right: 0;
}
</style>
@endsection
