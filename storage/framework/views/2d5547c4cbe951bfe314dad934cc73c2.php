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
    <form method="GET" action="<?php echo e(route('application.index')); ?>" id="searchForm" class="mb-3">
        <input type="text" name="search" id="searchInput" class="form-control"
               value="<?php echo e(request('search')); ?>" placeholder="Search by name or description" autocomplete="off">
    </form>

    <!-- Add Application Button -->
    <div class="mb-3">
        <a href="<?php echo e(route('gallery.index')); ?>" class="btn btn-secondary">Gallery Index</a>
        <a href="<?php echo e(route('application.create')); ?>" class="btn btn-success">+ Add Application</a>
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
            <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration); ?></td>
                    <td><?php echo e($application->name); ?></td>
                    <td><?php echo e(Str::limit($application->description, 50)); ?></td>
 <td>
        <?php if($application->gallery_images->isNotEmpty()): ?>
            <div class="d-flex flex-wrap gap-2">
                <?php $__currentLoopData = $application->gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('/app_images/' .$image->image)); ?>" class="rounded border p-1"
                         width="100" height="100" style="object-fit: cover;">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <span class="text-muted">No images available</span>
        <?php endif; ?>
    </td>
                    <td><?php echo e($application->status); ?></td>
                    <td>
                        <a href="<?php echo e(route('application.edit', $application->id)); ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <a href="<?php echo e(route('application.delete', $application->id)); ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <?php echo e($applications->appends(request()->query())->links('pagination::bootstrap-5')); ?>

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
<?php /**PATH D:\xampp\htdocs\application-app\resources\views/index.blade.php ENDPATH**/ ?>