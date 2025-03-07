@extends('admin.layout')
@section('admin.content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">Brand Management</div>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#brandModal" style="margin: 10px;">
            <i class="fa fa-plus"></i> Add New
        </button>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand Name</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                @if($brand->thumbnail)
                                    <img src="{{ $brand->thumbnail }}" width="60" alt="Brand Thumbnail">
                                @else
                                    <img src="{{ asset('images/default-thumbnail.jpg') }}" width="60" alt="No Image">
                                @endif
                            </td>
                            <td>{{ $brand->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($brand->status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editBrandModal{{ $brand->id }}">
                                    <i class="fa fa-pencil"></i>
                            </button>

                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;" class="confirm-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger confirm-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @include('admin.brands.form', ['brand' => $brand])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.brands.form', ['brand' => null])
@include('components.alerts.success')
@include('components.alerts.error')
@include('components.confirm')
@endsection
