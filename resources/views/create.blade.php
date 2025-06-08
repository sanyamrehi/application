<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Create Profile</h4>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <!-- Name -->
                   <div class="mb-3">
                        <label for="validationname" class="form-label">name</label>
                        <input type="text" name="name" id="name" class="form-control is-valid" placeholder="Enter name" value="{{ old('name') }}"  required>
                        <!--validation feedback-->
                        <div class="invalid-feedback">
                            Please provide a unique name.
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" id="description" class="form-control is-valid" placeholder="Enter description" value="{{ old('description') }}" required>
                        <div class="invalid-feedback">Please provide a valid description.</div>
                    </div>

<label for="gallery_id" class="form-label">Select Images:</label>
<div class="row">
    @foreach ($images as $image)
        <div class="col-md-3 text-center">
            @if(file_exists(public_path('/app_images/' . $image->image))) <!-- Ensure image exists -->
                <img src="{{ asset('/app_images/' . $image->image) }}" class="img-thumbnail"
                     style="width:100px; height:100px; cursor:pointer;"
                     onclick="toggleCheckbox({{ $image->id }}, '{{ asset('/app_images/' . $image->image) }}')">

                <input type="checkbox" name="gallery_id[]" value="{{ $image->id }}" class="image-checkbox"
                       id="checkbox-{{ $image->id }}"
                       onchange="toggleImagePreview({{ $image->id }}, '{{ asset('/app_images/' .$image->image) }}')">
            @else
                <p class="text-danger">Image not found: {{ $image->image }}</p>
            @endif
        </div>
    @endforeach
</div>

<!-- Selected Images Preview Section -->
<h5 class="mt-3">Selected Images</h5>
<div id="preview-container" class="d-flex flex-wrap gap-2"></div>


                    <!-- Active Status -->
                    <div class="form-check">
                        <input type="checkbox" name="status" value="Active" class="form-check-input" id="statusCheck" required>
                        <label class="form-check-label" for="statusCheck">Active</label>
                        <div class="invalid-feedback">Please select the status.</div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('application.index') }}" class="btn btn-primary">Dashboard</a>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleCheckbox(imageId, imageUrl) {
        let checkbox = document.getElementById(`checkbox-${imageId}`);
        checkbox.checked = !checkbox.checked; // Toggle checkbox
        toggleImagePreview(imageId, imageUrl); // Update preview
    }

    function toggleImagePreview(imageId, imageUrl) {
        let checkbox = document.getElementById(`checkbox-${imageId}`);
        let previewContainer = document.getElementById('preview-container');
        let existingImg = document.getElementById(`preview-${imageId}`);

        if (checkbox.checked) {
            // Add image preview if it doesn't already exist
            if (!existingImg) {
                let img = document.createElement('img');
                img.src = imageUrl;
                img.id = `preview-${imageId}`;
                img.className = 'img-thumbnail';
                img.style = 'width:100px; height:100px; margin-right:10px;';
                previewContainer.appendChild(img);
            }
        } else {
            // Remove image from preview if unchecked
            if (existingImg) {
                existingImg.remove();
            }
        }
    }
</script>
</body>
</html>
