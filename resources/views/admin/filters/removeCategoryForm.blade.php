<form action="/admin/filter-category?id={{$category->csp_id}}&uid={{$uid}}" method="post">
    @csrf
    @method('DELETE')
    <div class="d-flex flex-row-reverse">
        <button type="submit" class="btn btn-dark">Remove this Category</button>
    </div>
</form>

