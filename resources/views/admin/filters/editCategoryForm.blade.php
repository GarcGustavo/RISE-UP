<form action="/admin/filter-category/{{$category->csp_id}}" method="post">
	@method('PUT')
	@csrf
    <div class="d-flex flex-row">
        <button type="submit" class="btn btn-dark m-2">Edit Category</button>
        <input class="m-2" type="text" id="csp_name" name="csp_name" value="{{$category->csp_name}}">
    </div>
    @if($errors->has('csp_name'))
        <span class="text-danger">{{ $errors->first('csp_name') }}</span>
    @endif 
</form>