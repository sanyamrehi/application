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
            <!--Update form-->
                <form action="{{ route('application.update',['id' => $application['id']]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <!-- name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter name" value="{{ old('name', $application['name']) }}" required>
                        <div class="invalid-feedback">
                        @if ($errors->has('name'))
    <div class="alert alert-danger">
        {{ $errors->first('name') }}
    </div>
@endif
                        </div>
                    </div>
                    <!-- Model -->
                    <div class="mb-3">
                        <label for="validationdescription" class="form-label">description</label>
                        <input type="text" name="description" id="description" class="form-control is-valid" placeholder="Enter description" value="{{ $application['description'] }}" pattern="[A-Za-z\s]+" required>
                        <!--validation feedback-->
                        <div class="invalid-feedback">
                            Please provide a valid description .
                        </div>
                    </div>

                    <!-- Image -->
@php
    $selectedImages = json_decode($application->gallery_id, true) ?? [];
@endphp

<label for="gallery_id" class="form-label">Select Images:</label>
<div class="row">
    @foreach ($images as $image)
        <div class="col-md-3 text-center">
            <img src="{{ asset('/app_images/' .$image->image) }}" class="img-thumbnail"
                 style="width:100px; height:100px; cursor:pointer;"
                 onclick="toggleSelection({{ $image->id }}, '{{ asset('/app_images/' .$image->image) }}')">

            <input type="checkbox" name="gallery_id[]" value="{{ $image->id }}" class="image-checkbox"
                   {{ in_array($image->id, $selectedImages) ? 'checked' : '' }}
                   onchange="togglePreview({{ $image->id }}, '{{ asset('/app_images/' .$image->image) }}')">
        </div>
    @endforeach
</div>

<!-- Selected Images Preview -->
<h5 class="mt-3">Selected Images</h5>
<div id="preview-container" class="d-flex flex-wrap gap-2">
    @foreach ($images as $image)
        @if (in_array($image->id, $selectedImages))
            <img src="{{ asset('/app_images/' .$image->image) }}" id="preview-{{ $image->id }}"
                 class="img-thumbnail" style="width:100px; height:100px; margin-right:10px;">
        @endif
    @endforeach
</div>

                    <div class="form-control">
                        <input type="checkbox" name="status" value="Active" value="Active" {{ old('status', $application->status ?? '') == 'Active' ? 'checked' : '' }}>
                        <label>Active</label><br /><br />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Save</button>
                    <!--Index page -->
                    <a href="{{ route('application.index') }}" class="btn btn-primary">Index Page</a>
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
