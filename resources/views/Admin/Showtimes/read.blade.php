<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showtimes - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Showtimes Management</h4>
                        <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Showtime
                        </a>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($showtimes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Movie</th>
                                            <th>Theater</th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($showtimes as $showtime)
                                            <tr>
                                                <td>
                                                    <strong>{{ $showtime->movie->title }}</strong><br>
                                                    <small class="text-muted">{{ $showtime->movie->genre }}</small>
                                                </td>
                                                <td>
                                                    {{ $showtime->theater->name }}<br>
                                                    <small class="text-muted">{{ $showtime->theater->capacity }} seats</small>
                                                </td>
                                                <td>{{ $showtime->start_time->format('M d, Y') }}</td>
                                                <td>{{ $showtime->start_time->format('H:i') }}</td>
                                                <td>{{ $showtime->end_time->format('H:i') }}</td>
                                                <td>{{ $showtime->movie->duration }} min</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.showtimes.edit', $showtime) }}"
                                                           class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.showtimes.destroy', $showtime) }}"
                                                              method="POST"
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this showtime?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $showtimes->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5>No Showtimes Found</h5>
                                <p class="text-muted">Start by creating your first showtime.</p>
                                <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create First Showtime
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
