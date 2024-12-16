@extends('core.layouts.page')

@section('content_header')
<h1>
    Indirizzi <small>Comuni</small>
</h1>
@stop

@section('css')
@stop

@section('content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>Modifica Comune</h3>

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
                <div class="box-body">
                    <form method='POST' action='{{ route('core_cities.update', $coreCity) }}'>
                        @method('PATCH')
                        @csrf
                        <div class='row form-group'>
                            <div class='col-md-12'>
                                <div class='col-md-3'>
                                    <label class='col-form-label required'>Comune:</label>
                                    <input class='form-control' name='name' value='{{ old('name', $coreCity->name) }}'
                                    />
                                </div>
                                <div class='col-md-3'>
                                    <label class='col-form-label required' for='zip'>CAP:</label>
                                    <input class='form-control' name='zip' class='form-control' value='{{old('zip', $coreCity->zip)}}'>
                                </div>
                                <div class='col-md-3'>
                                    <label class='col-form-label required' for='city_name'>Provincia:</label>
                                    <select name='core_province_id' class='form-control' style='width: 100%'>
                                        <option></option>
                                        @foreach($coreProvinces as $coreProvince)
                                        <option value='{{$coreProvince->id}}' {{ old('core_province_id', $coreCity->core_province_id) == $coreProvince->id ? 'selected' : '' }}>
                                            {{$coreProvince->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class='col-md-12'>
                            <a class='btn btn-warning pull-left' href='{{ route('core_cities.index') }}'>
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

@section('js')
@endsection