<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content>
        <meta name="author" content>

        <title>Modern Business - Start Bootstrap Template</title>

        <!-- Bootstrap core CSS -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">


        <!-- Custom styles for this template -->
        <link href="{{asset('css/modern-business.css')}}" rel="stylesheet">

    </head>

    <body>
        <div id="app">
            <<div class="container">
                <iren_header></iren_header>
        </div>
        </div>

        <div class="body">
            <!-- Page Heading/Breadcrumbs -->
            <h1 class="mt-4 mb-3">About
                <small>Subheading</small>
            </h1>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item active">About</li>
            </ol>

            <!-- Intro Content -->
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img class="img-fluid rounded  mb-4" src="http://placehold.it/1080x608" alt="">
                </div>
            </div>
            <hr>
            <div class="card h-100 text-center">
                <div class="col-lg-12">
                    <h2>About Modern Business</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur
                        similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem
                        perferendis dicta dolorem non blanditiis ex fugiat.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, magni, aperiam vitae illum
                        voluptatum aut sequi impedit non velit ab ea pariatur sint quidem corporis eveniet. Odit,
                        temporibus reprehenderit dolorum!</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, consequuntur, modi mollitia
                        corporis ipsa voluptate corrupti eum ratione ex ea praesentium quibusdam? Aut, in eum facere
                        corrupti necessitatibus perspiciatis quis?</p>
                </div>
            </div>

            <div id="app">
                <<div class="container">
                    <iren_footer></iren_footer>
            </div>

            <script src="{{asset('js/app.js')}}"></script>
    </body>

</html>
