<form action="/admin/filter-option/{{$option->oid}}" method="post">
    @method('DELETE')
    @csrf
    <div class="d-flex flex-row">
        <span class="mr-auto"> {{$option->o_content}} </span>
        <button type="submit" class="btn btn-dark">Remove this Filter</button>
    </div>
</form>

