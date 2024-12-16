@extends('core.layouts.page')

@section('content_header')
    <h1>
        Rezervări <small>Modificare</small>
    </h1>
@stop

@section('css')
    <link href="/css/core/libraries/bootstrap-datepicker.min.css" rel="stylesheet" />
    <style>
        .form-control[disabled],
        .form-control[readonly] {
            background-color: #f9f9f9;
            color: #6c757d;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            {{-- @php
                dd($coreReservation);
            @endphp --}}
            <div class="col-md-12">
                <form action="{{ route('core_reservations.update', $coreReservation) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3>Modify Reservation</h3>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fas fa-info-circle text-success"></i>
                                <strong>Generals Details</strong>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                {{-- Selection Client --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">Client</label>
                                        <select name="core_user_id" class="form-control select2">
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    {{ $client->id == old('core_user_id', $coreReservation->core_user_id) ? 'selected' : '' }}>
                                                    {{ $client->username }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Selection Doctor --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">Doctor</label>
                                        <select name="doctor_id" class="form-control select2">
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}"
                                                    {{ $doctor->id == old('doctor_id', $coreReservation->doctor_id) ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Selectare Specializare --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">Speicalization</label>
                                        <select name="specialization_id" class="form-control select2">
                                            @foreach ($specializations as $specialization)
                                                <option value="{{ $specialization->id }}"
                                                    {{ $specialization->id == old('specialization_id', $coreReservation->specialization_id) ? 'selected' : '' }}>
                                                    {{ $specialization->specialization_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Selection time reservation --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">Time Reservation</label>
                                        <select name="reservation_slot_id" class="form-control select2">
                                            @foreach ($reservationSlots as $slot)
                                                <option value="{{ $slot->id }}"
                                                    {{ $slot->id == old('reservation_slot_id', $coreReservation->reservation_slot_id) ? 'selected' : '' }}>
                                                    {{ $slot->time }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Selection Status --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="0" {{ old('status', $coreReservation->status) == '0' ? 'selected' : '' }}>
                                                Waiting
                                            </option>
                                            <option value="1" {{ old('status', $coreReservation->status) == '1' ? 'selected' : '' }}>
                                                Confirmed
                                            </option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-12">
                        <a class="btn btn-warning pull-left" href="{{ route('core_reservations.index') }}">
                            <i class="fas fa-times"></i> Canceled
                        </a>
                        <button class="btn btn-primary pull-right">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/core/libraries/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>
@stop
