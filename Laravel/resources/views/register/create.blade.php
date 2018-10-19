<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet"  href="{{asset('css/app.css')}}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            body{
                background-color: darkred;
            }
        </style>
    </head>

    <body>
    @include('layouts.navbar')

    <div class="container">
        <div id="app">
            <register></register>
        </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>

    </body>
</html>
