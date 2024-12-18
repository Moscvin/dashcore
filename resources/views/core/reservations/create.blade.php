@extends('core.layouts.page')

@section('content_header')
    <h1>
        <small>Creare</small>
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
                <form action="{{ route('core_reservations.store') }}" method="post">
                    @csrf
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3>Creare Rezervare</h3>
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
                                                    <option value="{{ $specialization->id }}">
                                                        {{ $specialization->specialization_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Doctor</label>
                                            <select id="doctor" name="doctor_id" class="form-control select2" required>
                                                <option value="">Selectați un doctor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Timpul Rezervării</label>
                                            <select id="reservation_slot" name="reservation_slot_id"
                                                class="form-control select2" required>
                                                <option value="">Selectați un timp</option>
                                            </select>
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
            $('#specialization').on('change', function() {
                const specializationId = $(this).val();
                const doctorSelect = $('#doctor');
                const slotSelect = $('#reservation_slot');

                doctorSelect.html('<option value="">Select a doctor</option>');
                slotSelect.html('<option value="">Select a time</option>');

                if (specializationId) {
                    $.ajax({
                        url: "{{ route('core_reservations.doctors') }}",
                        type: 'GET',
                        data: {
                            specialization_id: specializationId
                        },
                        success: function(doctors) {
                            doctors.forEach(function(doctor) {
                                doctorSelect.append(
                                    `<option value="${doctor.id}">${doctor.name}</option>`
                                );
                            });
                        },
                        error: function() {
                            alert('Eroare la încărcarea doctorilor. Încercați din nou.');
                        }
                    });
                }
            });
            $('#doctor').on('change', function() {
                const doctorId = $(this).val();
                const slotSelect = $('#reservation_slot');

                slotSelect.html('<option value="">Selectați un timp</option>');

                if (doctorId) {
                    $.ajax({
                        url: "{{ route('core_reservations.slots') }}",
                        type: 'GET',
                        data: {
                            doctor_id: doctorId
                        },
                        success: function(slots) {
                            slots.forEach(function(slot) {
                                slotSelect.append(
                                    `<option value="${slot.id}">${slot.time}</option>`
                                );
                            });
                        },
                        error: function() {
                            alert('Eroare la încărcarea sloturilor. Încercați din nou.');
                        }
                    });
                }
            });
        });
    </script>
@stop
