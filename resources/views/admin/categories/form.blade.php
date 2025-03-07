<div class="modal fade" id="{{ $category ? 'editCategoryModal'.$category->id : 'categoryModal' }}" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $category ? 'Edit Category' : 'Add New Category' }}
                    </header>
                    <div class="panel-body">
                        <form action="{{ $category ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
                            @csrf
                            @if($category)
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="categoryName">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="name" value="{{ $category->name ?? '' }}" required>
                            </div>

                            <div class="form-group">
                                <label for="categoryDescription">Description</label>
                                <textarea class="form-control" id="categoryDescription" name="description">{{ $category->description ?? '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">Activate</label>
                                <div>
                                    <label class="switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" value="1" {{ isset($category) && $category->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">{{ $category ? 'Update' : 'Create' }}</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
