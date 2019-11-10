@extends('admin.admin')

@section('adminMainContent')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @forelse($categories as $category)
                <a class="font-weight-bold nav-item nav-link @if ($loop->first) active @endif" id="nav-{{ str_replace(' ', 'X', $category->csp_name) }}-tab" data-toggle="tab" href="#nav-{{ str_replace(' ', 'X', $category->csp_name) }}" role="tab" aria-controls="nav-{{ str_replace(' ', 'X', $category->csp_name) }}" aria-selected=@if ($loop->first)"true"@else"false"@endif>{{$category->csp_name}}</a>
            @empty

            @endforelse
        </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">
        @forelse($categories as $category)
        <div class="tab-pane fade @if ($loop->first) show active @endif" id="nav-{{ str_replace(' ', 'X', $category->csp_name) }}" role="tabpanel" aria-labelledby="nav-{{ str_replace(' ', 'X', $category->csp_name) }}-tab">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    <div class="d-flex flex-row-reverse">
                        <a href="#" class="badge badge-danger m-2">Remove this Category</a>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <a href="#" class="badge badge-success m-2">Add new Category</a>
                        <span> new cate </span>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                    @forelse($options as $option)
                        @if ($loop->parent->iteration == $option->o_parameter)
                            <li class="list-group-item d-flex">
                                <span class="mr-auto"> {{$option->o_content}} </span>
                                <a href="#" class="badge badge-danger p-1">-</a>
                            </li>
                        @endif
                    @empty

                    @endforelse
                            <li class="list-group-item d-flex">
                                <span class="mr-auto"> new option </span>
                                <a href="#" class="badge badge-success p-1">+</a>
                            </li>
                    </ul>
                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>

        </div> <!-- id nav {{$category->csp_name}} -->
        @empty
            <div class="alert alert-error">
                No filter categories defined.
            </div>
        @endforelse
    </div>  <!-- nav-tabContent  -->
@endsection
