<form action="/admin/filter-option" method="post">
    @csrf
    <li class="list-group-item d-flex">
        <button type="submit" class="btn btn-dark m-2">Add Filter</button>
        <input class="m-2" type="text" id="o_content" name="o_content" placeholder="New Filter">
        <input type="hidden" id="o_parameter" name="o_parameter" value={{$category->csp_id}}>
    </li>
    @if($errors->has('o_content'))
        <span class="alert alert-danger">{{ $errors->first('o_content') }}</span>
    @endif
</form>

