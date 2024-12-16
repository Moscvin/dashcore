@extends('core.layouts.main')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => '',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">
        <div class="sidebar-overlay"></div>
        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            <img src="{{config('app_header_logo_url')}}"  alt="{{config('meta_title')}}" />
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('core.layouts.partials.menu.menu-item', $appMenuItems, 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><img src="{{url(config('favicon_url'))}}"  alt="{{config('meta_title')}}" /></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><img src="{{config('app_header_logo_url')}}"  alt="{{config('meta_title')}}" /></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 138.000000 122.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,122.000000) scale(0.100000,-0.100000)" stroke="none">
                        <path d="M40 1010 l0 -70 625 0 625 0 0 70 0 70 -625 0 -625 0 0 -70z"></path>
                        <path d="M40 620 l0 -70 625 0 625 0 0 70 0 70 -625 0 -625 0 0 -70z"></path>
                        <path d="M40 230 l0 -70 625 0 625 0 0 70 0 70 -625 0 -625 0 0 -70z"></path>
                        </g>
                    </svg>
                </a>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('content_header')
                </section>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        @if (!Auth::guest())
                            <li class="dropdown">
                                {{-- dropdown-toggle --}}
                                <button type="button" class="nav-button" style="display: flex" data-bs-toggle="dropdown" aria-haspopup="true" data-bs-target="#dropdown-menu1" aria-expanded="false">
                                    <div class="drop_flex-user">
                                        <div class="drop_info_user">
                                            <span class="admin_dropdown">
                                                &nbsp;{{Auth::user()->name." ".Auth::user()->surname}} 
                                            </span>
                                            <br>
                                            <span class="admin_dropdown-group" style="margin-left: 3px">
                                                {{Auth::user()->coreGroup->name}}
                                            </span>
                                        </div>

                                        <div class="admin_icon-drop">
                                            <i class="fas fa-user" style="font-size: 16px;" aria-hidden="true"></i> 
                                        </div>
                                    </div>
                                </button>
                                <ul class="dropdown-menu" id="dropdown-menu1">
                                    <li class="text-center exit_user">
                                        @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                            <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                                <i class="fas fa-fw fa-power-off"></i> Esci
                                            </a>
                                        @else
                                            <a href="#"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            >
                                                <i class="fas fa-fw fa-sign-out"></i> Esci
                                            </a>
                                            <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                                @if(config('adminlte.logout_method'))
                                                    {{ method_field(config('adminlte.logout_method')) }}
                                                @endif
                                                {{ csrf_field() }}
                                            </form>
                                        @endif
                                    </li>

                                </ul>
                            </li>
                        @else
                            <li class="dropdown"><a href="/login" class="nav-button"><i class="fas fa-sign-in" aria-hidden="true"></i> Area riservata</a></li>
                        @endif
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        {{-- @if(config('adminlte.layout') != 'top-nav') --}}
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <div class="slimScrollDiv">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu" data-widget="tree">
                        @each('core.layouts.partials.menu.menu-item', $appMenuItems, 'item')
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </div>
        </aside>
        {{-- @endif --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
            </div>
            {!! config('web_application_footer') !!}
        </footer>

    </div>
    <!-- ./wrapper -->
@endsection
@section('scripts')
    @stack('js')
    @yield('js')
@endsection