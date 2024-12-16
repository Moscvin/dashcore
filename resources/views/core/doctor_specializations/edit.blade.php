@extends('core.layouts.page')

@section('content_header')
    <h1>
        Modifica Specializzazione del Doctor
    </h1>
@stop

@section('css')
@stop

@section('content')
    <div class='container-fluid spark-screen'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='box box-primary'>
                    <div class='box-header with-border'>
                        <h3>Modifica Specializzazione del Doctor</h3>
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
                        <form method='POST' action='{{ route('doctor_specialization.update', $doctorSpecialization) }}'>
                            @method('PATCH')
                            @csrf
                            <div class='row form-group'>
                                <div class='col-md-6'>
                                    <label for='doctor_id' class='col-form-label required'>Doctor:</label>
                                    <select class='form-control' name='doctor_id' id='doctor_id'>
                                        @foreach ($doctors as $doctor)
                                            <option value='{{ $doctor->id }}'
                                                {{ $doctorSpecialization->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class='col-md-6'>
                                    <label for='specialization_id' class='col-form-label required'>Specializzazione:</label>
                                    <select class='form-control' name='specialization_id' id='specialization_id'>
                                        @foreach ($specializations as $specialization)
                                            <option value='{{ $specialization->id }}'
                                                {{ $doctorSpecialization->specialization_id == $specialization->id ? 'selected' : '' }}>
                                                {{ $specialization->specialization_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class='col-md-12'>
                                <a class='btn btn-warning pull-left' href='{{ route('doctor_specialization.index') }}'>
                                    <i class='fas fa-times'></i> Annulla
                                </a>
                                <button type='submit' class='btn btn-primary pull-right'>
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
