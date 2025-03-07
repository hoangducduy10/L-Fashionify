<div class="modal fade" id="{{ $brand ? 'editBrandModal'.$brand->id : 'brandModal' }}" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $brand ? 'Edit Brand' : 'Add New Brand' }}
                    </header>
                    <div class="panel-body">
                        <form action="{{ $brand ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" 
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($brand)
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="brandName">Brand Name</label>
                                <input type="text" class="form-control" id="brandName" name="name" 
                                       value="{{ old('name', $brand->name ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="brandThumbnail">Thumbnail</label>
                                <input type="file" class="form-control" id="brandThumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event, '{{ $brand ? 'editBrandThumbnail'.$brand->id : 'brandThumbnailPreview' }}')">
                                
                                <div class="mt-2">
                                    <img id="{{ $brand ? 'editBrandThumbnail'.$brand->id : 'brandThumbnailPreview' }}" 
                                         src="{{ $brand && $brand->thumbnail ? asset($brand->thumbnail) : asset('images/default-thumbnail.jpg') }}" 
                                         alt="Brand Thumbnail" class="img-thumbnail" width="150">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Activate</label>
                                <div>
                                    <label class="switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" value="1" {{ isset($brand) && $brand->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">{{ $brand ? 'Update' : 'Create' }}</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById(previewId).src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
