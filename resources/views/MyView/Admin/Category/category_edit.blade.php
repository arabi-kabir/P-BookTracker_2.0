<form method="post" action="{{ route('admin.category.update') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $category->category_id }}">
    <div class="form-group">
        <label class="col-form-label" for="simpleinput">Category Name</label>
        <div>
            <input type="text" id="simpleinput" class="form-control" name="name" value="{{ $category->category_name }}" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary float-right">UPDATE</button>
</form>
