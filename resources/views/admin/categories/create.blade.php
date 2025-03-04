@extends('admin.layout')

@section('admin.content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Product Category
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name" placeholder="Enter category name">
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="description" placeholder="Enter category description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Activate this category</label>
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




