@extends('core.layouts.page')

@section('content_header')
    <h1>
        <small>Editare Rezervare</small>
    </h1>
@stop

@section('css')
    <link href="/css/core/libraries/select2.min.css" rel="stylesheet" />
    <link href="/css/core/libraries/select2-dashcore.css" rel="stylesheet" />
    <style>
        .mt-23 {
            margin-top: 28px;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('manager_reservation.update', $coreReservation) }}" method="post">
                    @csrf
                    @method('PATCH')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3>Editare Rezervare</h3>
                        </div>
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fas fa-table text-success"></i>
                                    <strong>Detalii Rezervare</strong>
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="required">Specializare</label>
                                            <input type="text" class="form-control"
                                                value="{{ $coreReservation->specialization->specialization_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Doctori</label>
                                            <select id="doctors" name="doctor_id" class="form-control select2" required>
                                                <option value="">Selectați un doctor</option>
                                                @foreach ($doctors->where('specialization_id', $coreReservation->specialization_id) as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                        {{ $doctor->id == $coreReservation->doctor_id ? 'selected' : '' }}>
                                                        {{ $doctor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select id="status" name="status" class="form-control select2" required>
                                                <option value="">Selectați statusul</option>
                                                <option value="0"
                                                    {{ $coreReservation->status == 0 ? 'selected' : '' }}>Inactiv
                                                </option>
                                                <option value="1"
                                                    {{ $coreReservation->status == 1 ? 'selected' : '' }}>Activ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Intervale de timp</label>
                                            <select id="slot_times" name="slot_times" class="form-control select2" required>
                                                @foreach ($reservationSlots as $slot)
                                                    <option value="{{ $slot->time }}"
                                                        {{ in_array($slot->time, $coreReservation->reservationSlots->pluck('time')->toArray()) ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::parse($slot->time)->format('Y-m-d H:i') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-md-12">
                <a class="btn btn-warning pull-left" href="{{ route('manager_reservation.index') }}">
                    <i class="fas fa-times"></i> Anulare
                </a>
                <button class="btn btn-primary pull-right save_btn">
                    <i class="fas fa-save"></i> Salvare
                </button>
            </div>
        </div>
        </form>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="/js/core/libraries/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'dashcore',
                width: '100%'
            });
        });
    </script>
@stop
