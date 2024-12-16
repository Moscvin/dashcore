<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>
            @yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('meta_title'))
            @yield('title_postfix', config('adminlte.title_postfix', ''))
        </title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        @include('core.layouts.partials.styles')
        @yield('adminlte_css')
    </head>
    <body class="hold-transition @yield('body_class')">
        @yield('body')

        @include('core.layouts.partials.scripts')
        
        @yield('scripts')
    </body>
</html>
