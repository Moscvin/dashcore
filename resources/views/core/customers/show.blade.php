@extends('core.layouts.page')

@section('content_header')
    <h1>
        Clienti <small>Gestione</small>
    </h1>
@stop

@section('css')
<link href="/css/core/libraries/select2.min.css" rel="stylesheet" />
<!-- <link href="/css/core/libraries/select2-bootstrap.min.css" rel="stylesheet" /> -->
<link href="/css/core/libraries/select2-dashcore.css" rel="stylesheet" />
<link href="/css/core/libraries/bootstrap-datepicker.min.css" rel="stylesheet" />
<style>
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    .autocomplete-items div:hover {
        /*when hovering an item:*/
        background-color: #e9e9e9;
    }

    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }

    .mt-23 {
        margin-top: 28px;
    }

    .pl-0 {
        padding-left: 0;
    }

    .pr-0 {
        padding-right: 0;
    }

    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .d-flex .form-group {
        width: 100%;
        margin-left: 15px;
        margin-right: 15px;
    }

    .d-flex .form-group:first-child {
        margin-left: 0;
    }

    .d-flex .form-group:last-child {
        margin-right: 0;
    }

    .d-flex .form-group.prefisso {
        width: 100px;
    }

    .d-flex .form-group.prefisso2 {
        width: 412px;
    }

    .w-50 {
        width: 22% !important;
    }

    .w-66 {
        width: 48% !important;
    }

    select {
        width: 100% !important;
    }
</style>
@stop

@section('content')
<div class="container-fluid spark-screen print_customer">
    <div class="row">
        <div class="col-md-12">
            @csrf
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>Visualizza Cliente</h3>
                </div>
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

            {{--Dati Generali--}}
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fas fa-table text-success"></i>
                        <strong>Dati Generali</strong>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipo cliente</label>
                                <input class="form-control" value="{{ $coreCustomer->typeText }}" disabled />
                            </div>
                        </div>
                        <div
                            class="col-md-10 type_legal {{ old('is_company', $coreCustomer->is_company) == 0 ?' hidden' : '' }}">
                            <div class="form-group ">
                                <label>Ragione Sociale</label>
                                <input class="form-control" value="{{ $coreCustomer->company_name }}" disabled>
                            </div>
                        </div>

                        <div
                            class="col-md-10 type_individual d-flex {{ old('is_company', $coreCustomer->is_company) == 1 ? ' hidden' : '' }}">
                            <div class="form-group">
                                <label for="surname">Cognome</label>
                                <input class="form-control" value="{{ $coreCustomer->surname }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input class="form-control" value="{{ $coreCustomer->name }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div
                        class="row type_individual {{ old('is_company', $coreCustomer->is_company) == 1 ? 'hidden' : ''}}">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="country_birth">Nazione di Nascita</label>
                                <input class="form-control" value="{{ $coreCustomer->country_birth }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-10 d-flex">
                            <div class="form-group">
                                <label>Data</label>
                                <input class="form-control" value="{{ $coreCustomer->dateBirthIt }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="city_birth">Comune</label>
                                <input class="form-control" value="{{ $coreCustomer->city_birth }}" disabled>
                            </div>
                            <div
                                class="form-group province_birth {{ old('country_birth', $coreCustomer->country_birth) == 'Italia' ? '' : 'hidden'}}">
                                <label for="province_birth">Provincia</label>
                                <input class="form-control" value="{{ $coreCustomer->province_birth }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div
                        class="row  type_legal {{ old('is_company', $coreCustomer->is_company) == 0 ? ' hidden' : '' }}">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="country_fiscal">Nazione</label>
                                <input class="form-control" value="{{ $coreCustomer->country_fiscal }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-10 d-flex">
                            <div class="form-group">
                                <label for="vat">Partita IVA</label>
                                <input class="form-control" value="{{ $coreCustomer->vat }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="code_fiscal">Codice Fiscale</label>
                                <input class="form-control" value="{{ $coreCustomer->code_fiscal }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div
                        class="row  type_individual {{ old('is_company', $coreCustomer->is_company) == 1 ? 'hidden' : '' }}">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nazione</label>
                                <input class="form-control" value="{{ $coreCustomer->country_fiscal }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="code_fiscal_individual">Codice Fiscale</label>
                                <input class="form-control" value="{{ $coreCustomer->code_fiscal }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--Indirizzi--}}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fas fa-building text-primary"></i>
                        <strong>Indirizzi</strong>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group mt-23">
                                <input class="form-control" value="{{ $coreCustomer->country_sl }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-10 d-flex">
                            <div class="form-group">
                                <label class="label_street_address_sl">{{ old('is_company', $coreCustomer->is_company)
                                    == 1 ? 'Sede Legale' : 'Residenza' }}</label>
                                <input class="form-control" value="{{ $coreCustomer->street_address_sl }}" disabled>
                            </div>
                            <div class="form-group">
                                <input class="form-control" value="{{ $coreCustomer->house_number_sl }}" disabled>
                            </div>
                            <div class="form-group prefix2">
                                <input class="form-control" value="{{ $coreCustomer->zip_sl }}" disabled>
                            </div>
                            <div class="form-group">
                                <input class="form-control" value="{{ $coreCustomer->city_sl }}" disabled>
                            </div>
                            <div class="form-group prefix2">
                                <input class="form-control" value="{{ $coreCustomer->province_sl }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group mt-23">
                                <input class="form-control" value="{{ $coreCustomer->country_so }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-10 d-flex">
                            <div class="form-group">
                                <label class="label_street_address_so">{{ old('is_company', $coreCustomer->is_company)
                                    == 1 ? 'Sede operativa' : 'Domicilio' }}</label>
                                <input class="form-control" value="{{ $coreCustomer->street_address_so }}" disabled>
                            </div>
                            <div class="form-group prefix2">
                                <input class="form-control" value="{{ $coreCustomer->house_number_so }}" disabled>
                            </div>
                            <div class="form-group prefix2">
                                <input class="form-control" value="{{ $coreCustomer->zip_so }}" disabled>
                            </div>
                            <div class="form-group">
                                <input class="form-control" value="{{ $coreCustomer->city_so }}" disabled>
                            </div>
                            <div class="form-group prefix2">
                                <input class="form-control" value="{{ $coreCustomer->province_so }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--End First Block Indirizzi--}}
            {{--Contact Data--}}
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fas fa-phone text-danger"></i>
                        <strong> Recapiti</strong>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="form-group w-50">
                                <label>Tel.</label>
                                <input class="form-control" value="{{ $coreCustomer->prefix_1 }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->phone_1 }}" disabled>
                            </div>
                            <div class="form-group w-50">
                                <label>Tel. 2</label>
                                <input class="form-control" value="{{ $coreCustomer->prefix_2 }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->phone_2 }}" disabled>
                            </div>
                            <div class="form-group w-50">
                                <label>Fax</label>
                                <input class="form-control" value="{{ $coreCustomer->prefix_fax }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->fax }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" value="{{ $coreCustomer->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>PEC</label>
                                <input class="form-control" value="{{ $coreCustomer->pec }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--END Contact Data--}}

            {{--Riferimenti--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fas fa-users text-primary"></i>
                        <strong> Riferimenti</strong>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="form-group">
                                <label>Rappresentante Legale</label>
                                <input class="form-control" value="{{ $coreCustomer->rl_surname }}" disabled>
                            </div>
                            <div class="form-group">
                                <input class="form-control" value="{{ $coreCustomer->rl_name }}" disabled>
                            </div>
                            <div class="form-group w-50">
                                <label>Tel.</label>
                                <input class="form-control" value="{{ $coreCustomer->rl_prefix_1 }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->rl_phone_1 }}" disabled>
                            </div>
                            <div class="form-group w-50">
                                <label>Tel. 2</label>
                                <input class="form-control" value="{{ $coreCustomer->rl_prefix_2 }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->rl_phone_2 }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" value="{{ $coreCustomer->rl_email }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="form-group">
                                <label>Referente</label>
                                <input class="form-control" value="{{ $coreCustomer->referent_surname }}" disabled>
                            </div>
                            <div class="form-group">
                                <input class="form-control" value="{{ $coreCustomer->referent_name }}" disabled>
                            </div>
                            <div class="form-group w-50">
                                <label>Tel.</label>
                                <input class="form-control" value="{{ $coreCustomer->referent_prefix_1 }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->referent_phone_1 }}" disabled>
                            </div>
                            <div class="form-group w-50">
                                <label>Tel. 2</label>
                                <input class="form-control" value="{{ $coreCustomer->referent_prefix_2 }}" disabled>
                            </div>
                            <div class="form-group w-66">
                                <input class="form-control" value="{{ $coreCustomer->referent_phone_2 }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" value="{{ $coreCustomer->referent_email }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--END Riferimenti--}}


            <div class="col-md-12">
                <a class="btn btn-warning pull-left" href="{{ route("core_customers.index") }}">
                    <i class="fas fa-times"></i> Indietro
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>
<script src="/js/core/libraries/select2.min.js"></script>
<script src="/js/core/libraries/bootstrap-datepicker.min.js"></script>
<script src="/js/core/core_customers/edit.js"></script>
@stop
