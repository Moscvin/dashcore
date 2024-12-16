@extends('core.layouts.page')


@section('content_header')
<h1>
    Admin Options <small>Elenco</small>
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
                    <h3>Nuova opzione</h3>

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
                    <form method="POST" action="{{ route('core_admin_options.store') }}">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label class="col-form-label required">Descrizione:</label>
                                    <input class="form-control" name="description" value="{{ old('description') }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label required">Valore:</label>
                                    <input class="form-control" name="value" value="{{ old('value') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-warning pull-left" href="{{ route('core_admin_options.index') }}">
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