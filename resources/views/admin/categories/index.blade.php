@extends('admin.layout')
@section('admin.content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Product Category List
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Created Date</th>
            <th>Status</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
          <tr>
              <td>
                  <label class="i-checks m-b-none">
                      <input type="checkbox" name="post[]"><i></i>
                  </label>
              </td>
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
                  <a href="#" class="edit-btn" data-toggle="modal" data-target="#editCategoryModal" 
                     data-id="{{ $category->id }}" 
                     data-name="{{ $category->name }}" 
                     data-description="{{ $category->description }}" 
                     data-status="{{ $category->status }}">
                      <i class="fa fa-pencil-square-o text-success"></i>
                  </a>
                  <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" class="confirm-form">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="confirm-btn" data-id="{{ $category->id }}" style="border:none; background:none; cursor:pointer;">
                          <i class="fa fa-trash text-danger"></i>
                      </button>
                  </form>
              </td>
          </tr>
          @endforeach
        </tbody>

      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="categoryDescription">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Activate Category</label>
                        <input type="hidden" name="status" value="0">
                        <label class="switch">
                            <input type="checkbox" id="status" name="status" value="1">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('components.alerts.success')
@include('components.alerts.error')
@include('components.confirm')
@endsection