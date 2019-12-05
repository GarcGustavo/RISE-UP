<form action="/admin/filter-category?uid={{$uid}}" method="post">
    @csrf
    <div class="d-flex flex-row">
        <button type="submit" class="btn btn-dark m-2">Add Category</button>
        <input class="m-2" type="text" id="csp_name" name="csp_name" placeholder="New Category">
    </div>
    @if($errors->has('csp_name'))
        <span class="text-danger">{{ $errors->first('csp_name') }}</span>
    @endif
</form>

