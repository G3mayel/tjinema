@extends('layouts.app')

@section('title', 'Create Showtime')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Create New Showtime</h4>
                    <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.showtimes.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="movie_id" class="form-label">Movie *</label>
                                    <select name="movie_id" id="movie_id" class="form-control" required>
                                        <option value="">Select Movie</option>
                                        @foreach($movies as $movie)
                                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                                {{ $movie->title }} ({{ $movie->duration }} min)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="theater_id" class="form-label">Theater *</label>
                                    <select name="theater_id" id="theater_id" class="form-control" required>
                                        <option value="">Select Theater</option>
                                        @foreach($theaters as $theater)
                                            <option value="{{ $theater->id }}" {{ old('theater_id') == $theater->id ? 'selected' : '' }}>
                                                {{ $theater->name }} ({{ $theater->capacity }} seats)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="start_time" class="form-label">Start Time *</label>
                                    <input type="datetime-local"
                                           name="start_time"
                                           id="start_time"
                                           class="form-control"
                                           value="{{ old('start_time') }}"
                                           required>
                                    <small class="form-text text-muted">End time will be calculated automatically based on movie duration</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Showtime
                            </button>
                            <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const startTimeInput = document.getElementById('start_time');
    const now = new Date();
    const minDateTime = now.toISOString().slice(0, 16);
    startTimeInput.min = minDateTime;
});
</script>
@endsection
