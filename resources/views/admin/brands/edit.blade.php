@extends('admin.layout')

@section('admin.content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Brand
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Brand Name -->
                        <div class="form-group">
                            <label for="brandName">Brand Name</label>
                            <input type="text" class="form-control" id="brandName" name="name" 
                                   value="{{ old('name', $brand->name) }}" required>
                        </div>

                        <!-- Thumbnail Upload -->
                        <div class="form-group">
                            <label for="brandThumbnail">Thumbnail</label>
                            <input type="file" class="form-control" id="brandThumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event)">
                            <div class="mt-2">
                                <img id="thumbnailPreview" 
                                     src="{{ $brand->thumbnail ? asset($brand->thumbnail) : asset('images/default-thumbnail.jpg') }}" 
                                     alt="Brand Thumbnail" class="img-thumbnail" width="150">
                            </div>
                        </div>

                        <!-- Activate Toggle -->
                        <div class="form-group">
                            <label for="status">Activate this brand</label>
                            <input type="hidden" name="status" value="0">
                            <label class="switch">
                                <input type="checkbox" name="status" value="1" {{ $brand->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-info">Update</button>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-default">Back</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('thumbnailPreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
