@extends('layout.layout')

@section('content')
<div class="mb-5 mt-5">
    <h1 class="mb-3">Admin</h1>
    <hr>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Menu</div>
            <div class="list-group list-group-flush">
                <a href="/admin/users-requests?uid={{$uid}}" class="list-group-item list-group-item-action bg-light">Users</a>
                <a href="/admin/users-actions?uid={{$uid}}" class="list-group-item list-group-item-action bg-light">Actions</a>
                <a href="/admin/filters?uid={{$uid}}" class="list-group-item list-group-item-action bg-light">Filters</a>
                <a href="/admin/groups?uid={{$uid}}" class="list-group-item list-group-item-action bg-light">Groups</a>
            </div>
        </div>
        <!-- sidebar -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-dark" id="menu-toggle">Hide</button>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0"></ul>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="mt-4">
                    @yield('adminMainContent')
                </div>
            </div>
        </div>
        <!-- page-content-->

    </div>
    <!-- id wrapper -->
</div>
@endsection
