@extends('core.layouts.page')


@section('content_header')
    <h1>
        Time <small>Elenco time</small>
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
    <div class='container-fluid spark-screen'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='box box-primary'>
                    <div class='box-header with-border'>
                        <h3>Modifica time</h3>
                        @if (count($errors) > 0)
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
                        <form method='POST' action='{{ route('core_reservations_slots.update', $coreSlots) }}'>
                            @method('PATCH')
                            @csrf
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <label class="col-form-label required">Time-Slot:</label>
                                        <input class="form-control" name="time" value="{{ old('time') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-12'>
                                <a class='btn btn-warning pull-left' href='{{ route('core_reservations_slots.index') }}'>
                                    <i class='fas fa-times'></i> Annulla
                                </a>
                                <button class='btn btn-primary pull-right'>
                                    <i class='fas fa-save'></i> Salva
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
