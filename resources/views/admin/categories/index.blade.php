@extends('admin.layout')

@section('admin.content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">Category Management</div>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#categoryModal" style="margin: 10px;">
            <i class="fa fa-plus"></i> Add New
        </button>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($category->status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editCategoryModal{{ $category->id }}">
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger  confirm-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @include('admin.categories.form', ['category' => $category])

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.categories.form', ['category' => null])
@include('components.alerts.success')
@include('components.alerts.error')
@include('components.confirm')
@endsection
