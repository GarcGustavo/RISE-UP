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

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>


        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
            integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">



        <!-- font for this template -->
        <link
            href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900'
            rel='stylesheet' type='text/css'>
        <!-- Include csrf protection -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

    <body>
        <div id="app">
            <iren-header></iren-header>
            <div class="container">
                @yield('content')
            </div>
            <iren-footer></iren-footer>
        </div>
        <script src="{{asset('js/app.js')}}">
        </script>

    </body>

    <style>
        /* body padding in reference to header */
        .container {
            padding-top: 60px;
        }

        #app {
            min-height: 100vh;
            /* will cover the 100% of viewport */
            display: block;
            position: relative;
            padding-bottom: 100px;
        }

        body {
            height: 100%;
            position: relative;
        }
    </style>

</html>
