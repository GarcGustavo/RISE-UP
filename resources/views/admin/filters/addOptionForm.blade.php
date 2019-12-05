<form action="/admin/filter-option?uid={{$uid}}" method="post">

    @csrf
    <button type="submit" class="btn btn-dark m-2">Add Filter</button>
	<input type="hidden" id="o_parameter" name="o_parameter" value={{$category->csp_id}}>
    <input class="m-2" type="text" id="o_content" name="o_content" placeholder="New Filter">
    @if($errors->has('o_content'))
        <span class="text-danger">{{ $errors->first('o_content') }}</span>
    @endif
</form>

