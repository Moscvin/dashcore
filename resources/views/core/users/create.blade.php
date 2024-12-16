@extends('core.layouts.page')

@section('content_header')
<h1>Utenti
    <small>Elenco utenti</small>
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
                    <h3>Nuovo utente</h3>

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
                    <form method="post" action="{{ route('core_users.store') }}">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label class="col-form-label required">Username:</label>
                                    <input class="form-control" name="username" value="{{ old('username') }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label required">Email:</label>
                                    <input class="form-control" name="email" value="{{ old('email') }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label required">Cognome:</label>
                                    <input class="form-control" name="surname" value="{{ old('surname') }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label" for="name">Nome:</label>
                                    <input class="form-control" name="name" value="{{ old('name') }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label required">Gruppo:</label>
                                    <select name="core_group_id" class="form-control" style="width: 100% !important">
                                        @foreach($coreGroups as $coreGroup)
                                        <option value="{{ $coreGroup->id }}" {{ old('core_group_id') == $coreGroup->id ? 'selected' : '' }}>
                                            {{ $coreGroup->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label required">Attivo:</label>
                                    <select class="form-control" name="active">
                                        <option value="0">No</option>
                                        <option value="1" selected>Si</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-warning pull-left" href="{{ route('core_users.index') }}">
                                <i class="fas fa-times"></i> Annulla
                            </a>
                            <button class="btn btn-primary pull-right">
                                <i class="fas fa-save"></i> Salva
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