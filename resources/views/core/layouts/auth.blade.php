<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('meta_title') }}</title>

    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ config('favicon_url') }}"/>

    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <link rel="stylesheet" href="{{ asset("libraries/fontawesome/css/all.min.css") }}">
    <style> 
        :root {
            --main-login-background: url({{ config('background_image_url') }});
        }      
    </style>
</head>
<body class="login-page" style="background-color:#367FA9;">

    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    @stack('js')

</body>
</html>
