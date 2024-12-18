@extends('core.layouts.page')

@section('content_header')
    <h1>
        Modifica Time-Slot <small>Elenco time</small>
    </h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("input[name='time']", {
                enableTime: true,
                noCalendar: false,
                dateFormat: "d-m-Y H:i",
                time_24hr: true
            });
        });
    </script>
@stop

@section('content')
    <div class='container-fluid spark-screen'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='box box-primary'>
                    <div class='box-header with-border'>
                        <h3>Modifica Time-Slot</h3>
                        @if ($errors->any())
                            <div class='alert alert-danger'>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class='box-body'>
                        <form method='POST' action='{{ route('core_reservation_slots.update', $reservationSlot->id) }}'>
                            @method('PATCH')
                            @csrf

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="col-form-label required">Time-Slot:</label>
                                    <input type="text" class="form-control" name="time"
                                        value="{{ old('time', \Carbon\Carbon::parse($reservationSlot->time)->format('d-m-Y H:i:s')) }}" />
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="col-form-label required">Doctor:</label>
                                    <select class="form-control" name="doctor_id" required>
                                        <option value="">-- Selectați un Doctor --</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ $reservationSlot->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="col-form-label">Este rezervat:</label>
                                    <select class="form-control" name="is_booked">
                                        <option value="0" {{ !$reservationSlot->is_booked ? 'selected' : '' }}>Nu
                                        </option>
                                        <option value="1" {{ $reservationSlot->is_booked ? 'selected' : '' }}>Da
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-12'>
                                    <a class='btn btn-warning pull-left' href='{{ route('core_reservation_slots.index') }}'>
                                        <i class='fas fa-times'></i> Anulează
                                    </a>
                                    <button type='submit' class='btn btn-primary pull-right'>
                                        <i class='fas fa-save'></i> Salvează
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
