@extends('layout')



@section('content')
<div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">Admin</h1>

    <hr>

    <!--  -->
    <div class="row">
        <div class="col-lg-2 mt-3 text-center">
            <ul class="list-group">
                <li class="list-group-item active">Users</li>
                <li class="list-group-item">Activity Log</li>
                <li class="list-group-item">Filters</li>
            </ul>
        </div>
        <div class="col-lg-10 mt-3">


        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="true">Users</a>
                <a class="nav-item nav-link" id="nav-requests-tab" data-toggle="tab" href="#nav-requests" role="tab" aria-controls="nav-requests" aria-selected="false">Requests</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                list users here
            </div>
            <div class="tab-pane fade" id="nav-requests" role="tabpanel" aria-labelledby="nav-requests-tab">list requests here</div>
        </div>


            <div>@yield('adminTable')</div>
        </div>
    </div>

</div>


<style>
    .card .card-body {

        padding-left: 20px;
        padding-right: 20px;
    }

    .card-title p
    {
        color: red !important;
        }
</style>
@endsection
