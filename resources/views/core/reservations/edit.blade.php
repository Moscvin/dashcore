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
                <form action="{{ route('core_reservations.update', $coreReservation) }}" method="post">
                    @csrf
                    @method('PATCH')
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Specializare</label>
                                            <select id="specialization" name="specialization_id"
                                                class="form-control select2" required>
                                                <option value="">Selectați o specializare</option>
                                                @foreach ($specializations as $specialization)
                                                    <option value="{{ $specialization->id }}"
                                                        {{ $specialization->id == $coreReservation->specialization_id ? 'selected' : '' }}>
                                                        {{ $specialization->specialization_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required">Intervale de timp</label>
                                            <div id="slot-times-container">
                                                @foreach ($coreReservation->reservationSlots as $slot)
                                                    <div class="input-group mb-2">
                                                        <input type="datetime-local" name="slot_times[]"
                                                            class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($slot->time)->format('Y-m-d\TH:i') }}"
                                                            required>
                                                        <button type="button"
                                                            class="btn btn-danger remove-slot-btn">-</button>
                                                    </div>
                                                @endforeach
                                                <div class="input-group mb-2">
                                                    <input type="datetime-local" name="slot_times[]" class="form-control">
                                                    <button type="button" class="btn btn-success add-slot-btn">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-warning pull-left" href="{{ route('core_reservations.index') }}">
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


            $(document).on('click', '.add-slot-btn', function() {
                $('#slot-times-container').append(`
                    <div class="input-group mb-2">
                        <input type="datetime-local" name="slot_times[]" class="form-control" required>
                        <button type="button" class="btn btn-danger remove-slot-btn">-</button>
                    </div>
                `);
            });

            $(document).on('click', '.remove-slot-btn', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
@stop
