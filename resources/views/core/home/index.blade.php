@extends('core.layouts.page')


@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <h4>Customers</h4>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-primary bg-gradient">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Revenue</p>
                            <h4 class="mb-0 mt-0 text-bold">$21,456</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-purple bg-gradient">
                                    <i class="fas fa-shop"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Orders</p>
                            <h4 class="mb-0 mt-0 text-bold">100</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                                <div class="avatar-title rounded bg-pink bg-gradient">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Customers</p>
                            <h4 class="mb-0 mt-0 text-bold">100</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="firstBox">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fas fa-wrench text-warning"></i>
                        <strong class="text-warning">Progetti da gestire</strong>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="row ">
                        <div class="col-md-3">
                            <div class="small-box bg-red bg-gradient">
                                <div class="inner">
                                    <h3>11</h3>
                                    <p>Progetti da assegnare</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-caret-square-right"></i>
                                </div>
                                <a href="#" class="small-box-footer">Vai
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="small-box bg-orange bg-gradient">
                                <div class="inner">
                                    <h3>4</h3>
                                    <p>Progetti da prendere in carico</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-plus-square"></i>
                                </div>
                                <a href="#" class="small-box-footer">Vai
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="small-box bg-info bg-gradient">
                                <div class="inner">
                                    <h3>4</h3>
                                    <p>Progetti da prendere in carico</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-plus-square"></i>
                                </div>
                                <a href="#" class="small-box-footer">Vai
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="small-box bg-primary bg-gradient">
                                <div class="inner">
                                    <h3>4</h3>
                                    <p>Progetti da prendere in carico</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-plus-square"></i>
                                </div>
                                <a href="#" class="small-box-footer">Vai
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection