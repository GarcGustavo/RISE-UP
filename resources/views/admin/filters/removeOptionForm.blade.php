<form action="/admin/filter-option/{{$option->oid}}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-dark">Remove this Filter</button>
</form>

