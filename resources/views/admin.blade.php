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
            <div class="d-flex">
                <ul class="list-inline mx-auto justify-content-center">
                    <li class="list-inline-item">Users</li>
                    <li class="list-inline-item">Request</li>
                </ul>
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
