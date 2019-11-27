<form action="/admin/filter-option/{{$option->oid}}" method="post">
    @method('DELETE')
    @csrf
    <li class="list-group-item d-flex">
        <span class="mr-auto"> {{$option->o_content}} </span>
        <button type="submit" class="btn btn-dark">Remove this Filter</button>
    </li>
</form>

