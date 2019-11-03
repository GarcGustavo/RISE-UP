@extends('admin.admin')

@section('adminMainContent')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @forelse($filters as $filter)
                <a class="nav-item nav-link @if ($loop->first) active @endif" id="nav-{{ str_replace(' ', 'X', $filter->csp_name) }}-tab" data-toggle="tab" href="#nav-{{ str_replace(' ', 'X', $filter->csp_name) }}" role="tab" aria-controls="nav-{{ str_replace(' ', 'X', $filter->csp_name) }}" aria-selected=@if ($loop->first)"true"@else"false"@endif>{{$filter->csp_name}}</a>
            @empty

            @endforelse
        </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">
        @forelse($filters as $filter)
        <div class="tab-pane fade @if ($loop->first) show active @endif" id="nav-{{ str_replace(' ', 'X', $filter->csp_name) }}" role="tabpanel" aria-labelledby="nav-{{ str_replace(' ', 'X', $filter->csp_name) }}-tab">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    {{$filter->csp_name}}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                    @forelse($options as $option)
                        @if ($loop->parent->iteration == $option->o_parameter)
                                <li class="list-group-item"> {{$option->o_content}} </li>
                        @endif
                    @empty

                    @endforelse
                    </ul>
                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>

        </div> <!-- id nav {{$filter->csp_name}} -->
        @empty
            <div class="alert alert-error">
                No filters defined.
            </div>
        @endforelse
    </div>  <!-- nav-tabContent  -->
@endsection
