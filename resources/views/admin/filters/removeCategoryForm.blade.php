<form action="/admin/filter-category/{{$category->csp_id}}" method="post">
    @csrf
    @method('DELETE')
    <div class="d-flex flex-row-reverse">
        <button type="submit" class="btn btn-dark">Remove this Category</button>
    </div>
</form>

