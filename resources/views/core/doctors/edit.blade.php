@extends('core.layouts.page')


@section('content_header')
    <h1>
        Doctor <small>Elenco doctor</small>
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
                        <h3>Modifica doctor</h3>
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
                        <form method='POST' action='{{ route('core_doctors.update', $coreDoctor) }}'>
                            @method('PATCH')
                            @csrf
                            <div class='row form-group'>
                                <div class='col-md-12'>
                                    <div class='col-md-2'>
                                        <label class='col-form-label required'>Nome:</label>
                                        <input class='form-control' name='name'
                                            value='{{ old(' name', $coreDoctor->name) }}' />
                                    </div>
                                    <div class='col-md-10'>
                                        <label class='col-form-label required'>Specializzazione:</label>
                                        <select class='form-specialization' name='specialization_id'>
                                            <option value=''>Seleziona una specializzazione</option>
                                            @foreach ($specializations as $specialization)
                                                <option value='{{ $specialization->id }}'
                                                    {{ $specialization->id == $coreDoctor->specialization_id ? 'selected' : '' }}>
                                                    {{ $specialization->specialization_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <div class='col-md-12'>
                    <a class='btn btn-warning pull-left' href='{{ route('core_doctors.index') }}'>
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
