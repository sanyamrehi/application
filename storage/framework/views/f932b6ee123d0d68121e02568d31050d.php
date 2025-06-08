<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Create Profile</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('gallery.update', ['id' => $galleries['id']])); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>

 <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)" value="<?php echo e($galleries['image']); ?>" >
                        <img src="<?php echo e(asset('app_images/' . $galleries['image'])); ?>" id="imagePreview" alt="Current Image" width="100">
                        <!--validation feedback-->
                        <div class="invalid-feedback">please choose a different image </div>
                    </div>
                         <input type="hidden" class="form-control" name="hdnimage" id="hdnimage" accept="image/*" value="<?php echo e($galleries['image']); ?>">


                    <div class="form-control">
                        <input type="checkbox" name="status" value="Active" value="Active" <?php echo e(old('status', $galleries->status ?? '') == 'Active' ? 'checked' : ''); ?>>
                        <label>Active</label><br /><br />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="<?php echo e(route('gallery.index')); ?>" class="btn btn-primary">Dashboard</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
//display of current image
        function previewImage(event) {
            const image = document.getElementById('imagePreview');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }


        (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

    </script><script>
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        //image display after selecting
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateImage(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const preview = document.getElementById("preview");
            const feedback = document.getElementById("imageFeedback");

            // Reset validation feedback
            fileInput.classList.remove("is-invalid");
            feedback.textContent = "";
            preview.style.display = "none";

            if (file) {
                // Validate file type
                const validTypes = ["image/jpeg", "image/png", "image/gif"];
                if (!validTypes.includes(file.type)) {
                    fileInput.classList.add("is-invalid");
                    feedback.textContent = "Please upload a valid image file (JPEG, PNG, or GIF).";
                    return;
                }

                // Validate file size (e.g., max 2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxSize) {
                    fileInput.classList.add("is-invalid");
                    feedback.textContent = "File size must not exceed 2MB.";
                    return;
                }

                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        }

    </script>

</body>
</html>
<?php /**PATH D:\xampp\htdocs\application-app\resources\views/gallery/edit.blade.php ENDPATH**/ ?>