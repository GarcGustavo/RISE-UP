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
                    <i class="fas fa-table mb-2"></i>
                    @if( ! $category->is_default )   
                        @include('admin.filters.removeCategoryForm')
					    @include('admin.filters.editCategoryForm')
                    @endif
                    @include('admin.filters.addCategoryForm')
                </div>
                <div class="card-body mt-5">
                    <ul class="list-group">
                    @forelse($options as $option)
                        @if ($category->csp_id == $option->o_parameter)
							<li class="list-group-item mb-5">
                                <div class="d-flex flex-row">
                                    <span class="mr-auto text-primary"> {{$option->o_content}} </span>
                                    @if( ! $option->is_default )
                                        @include('admin.filters.removeOptionForm')
                                    @endif
                                </div>
                                <div class="d-flex flex-row">
                                    @if( ! $option->is_default )
							            @include('admin.filters.editOptionForm')
                                    @endif
                                </div>
							</li>
                        @endif
                    @empty

                    @endforelse
                    <li class="list-group-item mb-5">
                        <div class="d-flex flex-row">
                            @include('admin.filters.addOptionForm')
                        </div>
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
