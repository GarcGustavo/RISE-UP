<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content>
        <meta name="author" content>

        <title>Interdisciplinary Research Network</title>

        <!-- Bootstrap core CSS -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- icons for this template -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- font for this template -->
        <link
            href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900'
            rel='stylesheet' type='text/css'>

    </head>

    <body>
        <div id="app">
            <iren_header></iren_header>
            <div class="container">
                @yield('content')
            </div>
            <iren_footer></iren_footer>
        </div>
        <script src="{{asset('js/app.js')}}">
        </script>

    </body>

    <style>
        /* body padding in reference to header */
        .container {
            padding-top: 55px;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

    </style>

</html>
