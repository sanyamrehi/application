<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Applications List</title>
    <link rel="shortcut icon" type="image/x-icon" href="icon.ico">
    <meta name="description" content="HTML, PHP, JSON, REST API">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        img { max-width: 100px; height: 100px; object-fit: cover; }
    </style>
</head>
<body class="container mt-4">

    <h2 class="mb-4">Applications List</h2>

    <!-- Search Bar (Auto-submit) -->
    <form method="GET" action="{{ route('application.index') }}" id="searchForm" class="mb-3">
        <input type="text" name="search" id="searchInput" class="form-control"
               value="{{ request('search') }}" placeholder="Search by name or description" autocomplete="off">
    </form>

    <!-- Add Application Button -->
    <div class="mb-3">
        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Gallery Index</a>
        <a href="{{ route('application.create') }}" class="btn btn-success">+ Add Application</a>
    </div>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Gallery</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $index => $application)
                <tr>
                    <td>{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                    <td>{{ $application->name }}</td>
                    <td>{{ Str::limit($application->description, 50) }}</td>
 <td>
        @if ($application->gallery_images->isNotEmpty())
            <div class="d-flex flex-wrap gap-2">
                @foreach ($application->gallery_images as $image)
                    <img src="{{ asset('/app_images/' .$image->image) }}" class="rounded border p-1"
                         width="100" height="100" style="object-fit: cover;">
                @endforeach
            </div>
        @else
            <span class="text-muted">No images available</span>
        @endif
    </td>
                    <td>{{ $application->status }}</td>
                    <td>
                        <a href="{{ route('application.edit', $application->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <a href="{{ route('application.delete', $application->id) }}" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this?')">
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $applications->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#searchInput').on('input', function () {
                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    $('#searchForm').submit();
                }.bind(this), 500); // Delay search request by 500ms
            });
        });
    </script>

</body>
</html>
