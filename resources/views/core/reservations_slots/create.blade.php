@extends('core.layouts.page')

@section('content_header')
    <h1>
        Time-Slot <small>Nuovo time</small>
    </h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("input[name='time']", {
                enableTime: true,
                noCalendar: false,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            });
        });
    </script>
@stop

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3>Nuovo Time-Slot</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="box-body">
                        <form method="POST" action="{{ route('core_reservation_slots.store') }}">
                            @csrf
                            <!-- Time-Slot Input -->
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="col-form-label required">Time-Slot:</label>
                                    <input class="form-control" name="time" value="{{ old('time') }}" />
                                </div>
                            </div>

                            <!-- Doctor Dropdown -->
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class="col-form-label required">Doctor:</label>
                                    <select class="form-control" name="doctor_id" required>
                                        <option value="">-- Seleziona un Doctor --</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn btn-warning pull-left"
                                        href="{{ route('core_reservation_slots.index') }}">
                                        <i class="fas fa-times"></i> Annulla
                                    </a>
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fas fa-save"></i> Salva
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
