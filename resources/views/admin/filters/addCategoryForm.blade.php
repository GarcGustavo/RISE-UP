<form action="/admin/filter-category" method="post">
    @csrf
    <div class="d-flex flex-row">
        <button type="submit" class="btn btn-dark m-2">Add Category</button>
        <input class="m-2" type="text" id="csp_name" name="csp_name" placeholder="New Category">
    </div>
    @if($errors->has('csp_name'))
        <span class="alert alert-danger">{{ $errors->first('csp_name') }}</span>
    @endif
</form>

