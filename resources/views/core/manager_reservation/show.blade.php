@extends('core.layouts.page')

@section('content_header')
    <h1>
        Rezervation <small>Details</small>
    </h1>
@stop

@section('css')
<style>
    .form-control[disabled], .form-control[readonly] {
        background-color: #f9f9f9;
        color: #6c757d;
    }
</style>
@stop

@section('content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>Rezervation Details</h3>
                </div>
                <div class="box-body">
                    {{-- Detalii Generale --}}
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fas fa-info-circle text-success"></i>
                                <strong>Generals Details</strong>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <input class="form-control" value="{{ $coreReservation->coreUser->username ?? 'N/A' }}" disabled />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <input class="form-control" value="{{ $coreReservation->doctor->name ?? 'N/A' }}" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Specialization</label>
                                        <input class="form-control" value="{{ $coreReservation->specialization->specialization_name ?? 'N/A' }}" disabled />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data și ora</label>
                                        <input class="form-control" value="{{ $coreReservation->reservationSlots->first()->time ?? 'N/A' }}" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input class="form-control" value="{{ $coreReservation->status ?? 'N/A' }}" disabled />
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contacte Client --}}
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fas fa-phone text-danger"></i>
                                <strong>Contact Client</strong>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" value="{{ $coreReservation->coreUser->email ?? 'N/A' }}" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Acțiuni --}}
                    <div class="col-md-12">
                        <a class="btn btn-warning pull-left" href="{{ route("core_reservations.index") }}">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    console.log('Rezervation Download: {{ $coreReservation->id }}');
</script>
@stop
