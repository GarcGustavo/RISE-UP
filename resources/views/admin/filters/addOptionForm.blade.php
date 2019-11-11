
    <form action="/admin/filter-" method="post">
        @csrf
        <li class="list-group-item d-flex">
            <button type="submit" class="btn btn-dark m-2">Add Filter</button>
            <input class="m-2" type="text" placeholder="New Filter">
        </li>
    </form>

