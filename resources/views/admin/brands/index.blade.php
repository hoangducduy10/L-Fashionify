@extends('admin.layout')
@section('admin.content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Brand List
        </div>

        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
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
                            <a href="{{ route('admin.brands.edit', $brand->id) }}">
                                <i class="fa fa-pencil-square-o text-success"></i>
                            </a>

                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;" class="confirm-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border:none; background:none; cursor:pointer;" class="confirm-btn">
                                    <i class="fa fa-trash text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('components.alerts.success')
@include('components.alerts.error')
@include('components.confirm')
@endsection
