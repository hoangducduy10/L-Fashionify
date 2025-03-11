<!-- resources/views/admin/products/index.blade.php -->
@extends('admin.layout')

@section('admin.content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">Product Management</div>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productModal" style="margin: 10px;">
            <i class="fa fa-plus"></i> Add New
        </button>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Thumbnail</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if($product->thumbnail)
                                    <img src="{{ $product->thumbnail }}" width="60" alt="Product Thumbnail">
                                @else
                                    <img src="{{ asset('images/default-thumbnail.jpg') }}" class="img-thumbnail default-logo" alt="No Image">
                                @endif
                            </td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ optional($product->productDetails->first())->quantity ?? 'N/A' }}</td>
                            <td>
                                @if($product->status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editProductModal{{ $product->id }}">
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger confirm-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @include('admin.products.form', ['product' => $product])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.products.form', ['product' => null])
@include('components.alerts.success')
@include('components.alerts.error')
@include('components.confirm')
@endsection
