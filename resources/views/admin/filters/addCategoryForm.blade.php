
    <form action="/admin/filter-category" method="post">
        @csrf
        <div class="d-flex flex-row">
            <button type="submit" class="btn btn-dark m-2">Add Category</button>
            <input class="m-2" type="text" placeholder="New Category">
        </div>
    </form>

