@extends('core.layouts.page')


@section('content_header')
<h1>
    Specialization<small>Elenco Specialization</small>
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
                    <h3>Nuovo Specialization</h3>
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
                    <form method="POST" action="{{ route('core_specialization.store') }}">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label class="col-form-label required">Specialization_name:</label>
                                    <input class="form-control" name="specialization_name" value="{{ old('specialization_name') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-warning pull-left" href="{{ route('core_specialization.index') }}">
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