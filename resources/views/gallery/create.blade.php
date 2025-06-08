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
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf


      <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)"required>
                        <img id="preview" class="img-thumbnail mt-2" style="max-width: 150px; display: none;">
                        <!--validation feedback-->
                        <div class="invalid-feedback">please provide a valid image </div>
                    </div>

                    <div class="form-control">
                        <input type="checkbox" name="status" value="Active">
                        <label>Active</label><br /><br />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('gallery.index') }}" class="btn btn-primary">Dashboard</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function previewImages(event) {
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = ''; // Clear previous previews

    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.classList.add('img-thumbnail');
                imgElement.style.maxWidth = '150px';
                imgElement.style.marginRight = '10px';
                previewContainer.appendChild(imgElement);
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
<script>
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
