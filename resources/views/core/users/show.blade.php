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
                        <h3>Visualizza utente</h3>
                    </div>

                    <div class="box-body">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label class="col-form-label">Username:</label>
                                    <input class="form-control" name="username" value="{{ $coreUser->username }}" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Email:</label>
                                    <input class="form-control" name="email" value="{{ $coreUser->email }}" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Cognome:</label>
                                    <input class="form-control" name="surname" value="{{ $coreUser->surname }}" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label" for="name">Nome:</label>
                                    <input class="form-control" name="name" value="{{ $coreUser->name }}" readonly />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Gruppo:</label>
                                    <input class="form-control" name="name" value="{{ $coreUser->coreGroup->name }}" readonly />
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label">Attivo:</label>
                                    <input class="form-control" name="name" value="{{ $coreUser->activeText }}" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-warning pull-left"  href="{{ route("core_users.index") }}">
                                <i class="fas fa-times"></i> Annulla
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
