<div class="modal fade" id="{{ $product ? 'editProductModal'.$product->id : 'productModal' }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title font-weight-bold">{{ isset($product) ? 'Edit Product: '.$product->name : 'Add New Product' }}</h4>
            </div>
            <div class="modal-body">
                    <form id="productForm" class="form-horizontal" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif
    
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="name">Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="brand_id">Brand <span class="text-danger">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="form-control" id="brand_id" name="brand_id" required>
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="category_id">Category <span class="text-danger">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="color_id">Color <span class="text-danger">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="form-control" id="color_id" name="color_id" required>
                                            <option value="">Select Color</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}" {{ old('color_id', optional($product?->productDetails->first())->color_id) == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="size">Size <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="size" name="size" value="{{ old('size', optional($product?->productDetails->first())->size) }}" required>
                                    </div>
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="price">Price <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ old('price', optional($product?->productDetails->first())->price) }}" required>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="discount_price">Discount</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="number" class="form-control" id="discount_price" name="discount_price" step="0.01" min="0" value="{{ old('discount_price', optional($product?->productDetails->first())->discount_price) }}">
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="{{ old('quantity', optional($product?->productDetails->first())->quantity) }}" required>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Thumbnail</label>
                                    <div class="col-sm-8 text-center">
                                        <div class="thumbnail-preview mb-2">
                                            <img id="productThumbnailPreview" 
                                                src="{{ isset($product) && $product->thumbnail ? $product->thumbnail : asset('images/default-thumbnail.jpg') }}" 
                                                class="img-thumbnail" 
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                        </div>
                                        <div class="input-group">
                                            <label class="btn btn-primary btn-file">
                                                <i class="fa fa-folder-open"></i> Browse
                                                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event)" hidden>
                                            </label>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Status</label>
                                    <div class="col-sm-8">
                                        <label class="switch">
                                            <input type="checkbox" id="status" name="status" value="1" {{ old('status', $product->status ?? false) ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
    
                            </div>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                <i class="fa fa-save"></i> {{ isset($product) ? 'Update Product' : 'Create Product' }}
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('productThumbnailPreview');
            preview.src = reader.result;
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

