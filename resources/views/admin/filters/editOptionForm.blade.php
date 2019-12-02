<form action="/admin/filter-option/{{$option->oid}}" method="post">
	@method('PUT')
	@csrf
    <div class="d-flex flex-row">
        <button type="submit" class="btn btn-dark m-2">Edit this filter</button>
		<input type="hidden" id="o_parameter" name="o_parameter" value={{$category->csp_id}}>   
        <input class="m-2" type="text" id="o_content" name="o_content" value="{{$option->o_content}}">
    </div>
    @if($errors->has('o_content'))
        <span class="text-danger">{{ $errors->first('o_content') }}</span>
    @endif 
</form>