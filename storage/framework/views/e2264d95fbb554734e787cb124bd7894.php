<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>update Profile</h4>
            </div>
             <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="card-body">
            <!--Update form-->
                <form action="<?php echo e(route('application.update',['id' => $application['id']])); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <!-- name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Enter name" value="<?php echo e(old('name', $application['name'])); ?>" required>
                        <div class="invalid-feedback">
                        <?php if($errors->has('name')): ?>
    <div class="alert alert-danger">
        <?php echo e($errors->first('name')); ?>

    </div>
<?php endif; ?>
                        </div>
                    </div>
                    <!-- Model -->
                    <div class="mb-3">
                        <label for="validationdescription" class="form-label">description</label>
                        <input type="text" name="description" id="description" class="form-control is-valid" placeholder="Enter description" value="<?php echo e($application['description']); ?>" pattern="[A-Za-z\s]+" required>
                        <!--validation feedback-->
                        <div class="invalid-feedback">
                            Please provide a valid description .
                        </div>
                    </div>

                    <!-- Image -->
<?php
    $selectedImages = json_decode($application->gallery_id, true) ?? [];
?>

<label for="gallery_id" class="form-label">Select Images:</label>
<div class="row">
    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3 text-center">
            <img src="<?php echo e(asset('/app_images/' .$image->image)); ?>" class="img-thumbnail"
                 style="width:100px; height:100px; cursor:pointer;"
                 onclick="toggleSelection(<?php echo e($image->id); ?>, '<?php echo e(asset('/app_images/' .$image->image)); ?>')">

            <input type="checkbox" name="gallery_id[]" value="<?php echo e($image->id); ?>" class="image-checkbox"
                   <?php echo e(in_array($image->id, $selectedImages) ? 'checked' : ''); ?>

                   onchange="togglePreview(<?php echo e($image->id); ?>, '<?php echo e(asset('/app_images/' .$image->image)); ?>')">
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Selected Images Preview -->
<h5 class="mt-3">Selected Images</h5>
<div id="preview-container" class="d-flex flex-wrap gap-2">
    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(in_array($image->id, $selectedImages)): ?>
            <img src="<?php echo e(asset('/app_images/' .$image->image)); ?>" id="preview-<?php echo e($image->id); ?>"
                 class="img-thumbnail" style="width:100px; height:100px; margin-right:10px;">
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

                    <div class="form-control">
                        <input type="checkbox" name="status" value="Active" value="Active" <?php echo e(old('status', $application->status ?? '') == 'Active' ? 'checked' : ''); ?>>
                        <label>Active</label><br /><br />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Save</button>
                    <!--Index page -->
                    <a href="<?php echo e(route('application.index')); ?>" class="btn btn-primary">Index Page</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('validationphone').addEventListener('input', function() {
            var phoneInput = document.getElementById('validationphone');//checks the phone is valid
            var feedback = phoneInput.nextElementSibling; // Get the invalid-feedback div

            // Check if the phone number matches the pattern
            if (phoneInput.validity.patternMismatch) {
                phoneInput.classList.add('is-invalid'); // Show invalid feedback
                feedback.style.display = 'block'; // Show the invalid-feedback
            } else {
                phoneInput.classList.remove('is-invalid'); // Hide invalid feedback
                feedback.style.display = 'none'; // Hide the invalid-feedback
            }
        });

    </script>
  <script>
function toggleSelection(imageId, imageUrl) {
    let checkbox = document.querySelector(`input[value="${imageId}"]`);
    checkbox.checked = !checkbox.checked;
    togglePreview(imageId, imageUrl);
}

function togglePreview(imageId, imageUrl) {
    const previewContainer = document.getElementById('preview-container');
    const checkbox = document.querySelector(`input[value="${imageId}"]`);

    if (checkbox.checked) {
        let imgElement = document.createElement('img');
        imgElement.src = imageUrl;
        imgElement.classList.add('img-thumbnail');
        imgElement.style.width = '100px';
        imgElement.style.height = '100px';
        imgElement.style.marginRight = '10px';
        imgElement.setAttribute('id', 'preview-' + imageId);
        previewContainer.appendChild(imgElement);
    } else {
        let imgToRemove = document.getElementById('preview-' + imageId);
        if (imgToRemove) {
            previewContainer.removeChild(imgToRemove);
        }
    }
}
</script>

</body>
</html>
<?php /**PATH D:\xampp\htdocs\application-app\resources\views/edit.blade.php ENDPATH**/ ?>