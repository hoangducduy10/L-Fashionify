@extends('admin.layout')

@section('admin.content')

<div class="panel panel-default">
    <div class="panel-heading">
        Edit Category
    </div>

    <div class="panel-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Activate</label>
                <label class="switch">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" id="status" name="status" value="1" {{ $category->status ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

@endsection
