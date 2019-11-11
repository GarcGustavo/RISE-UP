
    <form action="/admin/filter-" method="post">
        @csrf
        <li class="list-group-item d-flex">
            <span class="mr-auto"> {{$option->o_content}} </span>
            <button type="submit" class="btn btn-dark">Remove this Filter</button>
        </li>
    </form>

