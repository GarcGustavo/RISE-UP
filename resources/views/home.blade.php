@extends('layout.layout')


@section('content')

<div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">
        About
    </h1>

    <hr>

    <!-- Intro Content -->
    <div class="row">
        <div class="col-lg-12 mt-3 text-center">
            <img class="img-fluid rounded mb-4" src="http://placehold.it/1080x608" alt />
        </div>
    </div>
    <hr />
    <div class="info">
        <div class="card mt-5 border-0 ">
            <div class="card-body ">

                <h2 class="card-title">About Modern Business</h2>
                <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum
                    consectetur
                    similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit
                    voluptatem
                    perferendis dicta dolorem non blanditiis ex fugiat.
                </p>
            </div>
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
