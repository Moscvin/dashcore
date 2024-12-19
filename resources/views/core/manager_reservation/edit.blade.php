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
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Doctori</label>
                                            <select id="doctors" name="doctor_id" class="form-control select2" required>
                                                <option value="">Selectați un doctor</option>
                                                @foreach ($doctors as $doctor)
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
                                                    {{ $coreReservation->status == 0 ? 'selected' : '' }}>Inactiv</option>
                                                <option value="1"
                                                    {{ $coreReservation->status == 1 ? 'selected' : '' }}>Activ</option>
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

            // $(document).on('change', '#specialization', function() {
            //     let specializationId = $(this).val();
            //     if (specializationId) {
            //         $.ajax({
            //             url: '/api/doctors-by-specialization/' + specializationId,
            //             method: 'GET',
            //             success: function(response) {
            //                 let options = '<option value="">Selectați un doctor</option>';
            //                 response.forEach(function(doctor) {
            //                     options +=
            //                         `<option value="${doctor.id}">${doctor.name}</option>`;
            //                 });
            //                 $('#doctors').html(options);
            //             },
            //             error: function() {
            //                 alert('Eroare la încărcarea doctorilor.');
            //             }
            //         });
            //     } else {
            //         $('#doctors').html('<option value="">Selectați un doctor</option>');
            //     }
            // });

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
