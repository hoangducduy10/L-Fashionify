@extends('admin.layout')

@section('admin.content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Brand
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="brandName">Brand Name</label>
                            <input type="text" class="form-control" id="brandName" name="name" placeholder="Enter brand name" required>
                        </div>
                        <div class="form-group">
                            <label for="brandThumbnail">Thumbnail</label>
                            <input type="file" class="form-control" id="brandThumbnail" name="thumbnail" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="status">Activate this brand</label>
                            <input type="hidden" name="status" value="0">
                            <label class="switch">
                                <input type="checkbox" name="status" value="1">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
