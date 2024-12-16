@extends('core.layouts.page')

@section('content_header')
    <h1>
        Clienti <small>Gestione</small>
    </h1>
@stop

@section('css')
<!-- <link href="/css/core/libraries/select2-bootstrap.min.css" rel="stylesheet" /> -->
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
            <form action="{{ route('core_customers.update', $coreCustomer) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3>Modifica Cliente</h3>
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
                                    <label class="required">Tipo cliente</label>
                                    <select name="is_company" class="form-control" onchange="changeType(this.value)">
                                        <option {{ old('is_company', $coreCustomer->is_company) == 1 ? "selected" : ""
                                            }} value="1">
                                            Persona giuridica
                                        </option>
                                        <option {{ old('is_company', $coreCustomer->is_company) == 0 ? "selected" : ""
                                            }} value="0">
                                            Persone fisica
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div
                                class="col-md-10 type_legal {{ old('is_company', $coreCustomer->is_company) == 0 ?' hidden' : '' }}">
                                <div class="form-group ">
                                    <label class="required">Ragione Sociale</label>
                                    <input name="company_name" class="form-control"
                                        value="{{ old('company_name', $coreCustomer->company_name) }}" autofocus>
                                </div>
                            </div>

                            <div
                                class="col-md-10 type_individual d-flex {{ old('is_company', $coreCustomer->is_company) == 1 ? ' hidden' : '' }}">
                                <div class="form-group">
                                    <label class="required" for="surname">Cognome</label>
                                    <input id="surname" name="surname" class="form-control"
                                        value="{{ old('surname', $coreCustomer->surname) }}">
                                </div>
                                <div class="form-group">
                                    <label class="required" for="name">Nome</label>
                                    <input name="name" class="form-control"
                                        value="{{ old('name', $coreCustomer->name) }}">
                                </div>
                            </div>
                        </div>
                        <div
                            class="row type_individual {{ old('is_company', $coreCustomer->is_company) == 1 ? 'hidden' : ''}}">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="required" for="country_birth">Nazione di Nascita</label>
                                    <select name="country_birth" class="form-control"
                                        onchange="onChangeBirthCountry(this)">
                                        @foreach($coreCountries as $coreCountry)
                                        <option value="{{$coreCountry->name}}" {{ $coreCountry->name ==
                                            old('country_birth', $coreCustomer->country_birth) ? "selected" : "" }}>
                                            {{$coreCountry->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10 d-flex">
                                <div class="form-group">
                                    <label>Data</label>
                                    <input name="date_birth" class="form-control datepicker"
                                        value="{{ old('date_birth', $coreCustomer->dateBirthIt) }}">
                                </div>
                                <div class="form-group">
                                    <label for="city_birth">Comune</label>
                                    <input name="city_birth" class="form-control"
                                        value="{{ old('city_birth', $coreCustomer->city_birth) }}">
                                </div>
                                <div
                                    class="form-group province_birth {{ old('country_birth', $coreCustomer->country_birth) == 'Italia' ? '' : 'hidden'}}">
                                    <label for="province_birth">Provincia</label>
                                    <input name="province_birth" class="form-control"
                                        value="{{ old('province_birth', $coreCustomer->province_birth) }}">
                                </div>
                            </div>
                        </div>

                        <div
                            class="row  type_legal {{ old('is_company', $coreCustomer->is_company) == 0 ? ' hidden' : '' }}">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="required" for="country_fiscal">Nazione</label>
                                    <select class="form-control" name="country_fiscal">
                                        @foreach($coreCountries as $coreCountry)
                                        <option value="{{$coreCountry->name}}" {{ $coreCountry->name ==
                                            old('country_fiscal', $coreCustomer->country_fiscal) ? "selected" : "" }}>
                                            {{$coreCountry->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10 d-flex">
                                <div class="form-group">
                                    <label class="required" for="vat">Partita IVA</label>
                                    <input name="vat" value="{{ old('vat', $coreCustomer->vat) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="required" for="code_fiscal">Codice Fiscale</label>
                                    <input name="code_fiscal" maxlength="16"
                                        value="{{ old('code_fiscal', $coreCustomer->code_fiscal) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div
                            class="row  type_individual {{ old('is_company', $coreCustomer->is_company) == 1 ? 'hidden' : '' }}">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="required">Nazione</label>
                                    <select class="form-control" name="country_fiscal_individual">
                                        @foreach($coreCountries as $coreCountry)
                                        <option value="{{$coreCountry->name}}" {{ $coreCountry->name ==
                                            old('country_fiscal_individual', 'Italia') ? "selected" : "" }}>
                                            {{$coreCountry->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="required" for="code_fiscal_individual">Codice Fiscale</label>
                                    <input name="code_fiscal_individual" maxlength="16"
                                        value="{{ old('code_fiscal_individual', $coreCustomer->code_fiscal) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <select class="form-control" name="country_sl">
                                        @foreach($coreCountries as $coreCountry)
                                        <option value="{{$coreCountry->name}}" {{ $coreCountry->name ==
                                            old('country_sl', $coreCustomer->country_sl) ? "selected" : "" }}>
                                            {{$coreCountry->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10 d-flex">
                                <div class="form-group">
                                    <label class="label_street_address_sl">{{ old('is_company',
                                        $coreCustomer->is_company) == 1 ? 'Sede Legale' : 'Residenza' }}</label>
                                    <input class="form-control" name="street_address_sl" placeholder="Via/Piazza"
                                        value="{{ old('street_address_sl', $coreCustomer->street_address_sl) }}">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="house_number_sl" placeholder="Civico e int."
                                        value="{{ old('house_number_sl', $coreCustomer->house_number_sl) }}">
                                </div>
                                <div class="form-group prefix2">
                                    <input type="text" class="form-control" name="zip_sl" placeholder="CAP"
                                        value="{{ old('zip_sl', $coreCustomer->zip_sl) }}">
                                </div>
                                <div class="form-group">
                                    <select name="city_sl" class="form-control select2-city">
                                        @if (old('city_sl', $coreCustomer->city_sl))
                                        <option value="{{ old('city_sl', $coreCustomer->city_sl) }}">{{ old('city_sl',
                                            $coreCustomer->city_sl) }}</option>
                                        @else
                                        <option></option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group prefix2">
                                    <input type="text" class="form-control" name="province_sl" placeholder="Provincia"
                                        value="{{ old('province_sl', $coreCustomer->province_sl) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group mt-23">
                                    <select class="form-control" name="country_so">
                                        @foreach($coreCountries as $coreCountry)
                                        <option value="{{$coreCountry->name}}" {{ $coreCountry->name ==
                                            old('country_so', $coreCustomer->country_so) ? "selected" : "" }}>
                                            {{$coreCountry->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10 d-flex">
                                <div class="form-group">
                                    <label class="label_street_address_so">{{ old('is_company',
                                        $coreCustomer->is_company) == 1 ? 'Sede operativa' : 'Domicilio' }}</label>
                                    <input class="form-control" name="street_address_so" placeholder="Via/Piazza"
                                        value="{{ old('street_address_so', $coreCustomer->street_address_so) }}">
                                </div>
                                <div class="form-group prefix2">
                                    <input class="form-control" name="house_number_so" placeholder="Civico e int."
                                        value="{{ old('house_number_so', $coreCustomer->house_number_so) }}">
                                </div>
                                <div class="form-group prefix2">
                                    <input class="form-control" name="zip_so" placeholder="CAP"
                                        value="{{ old('zip_so', $coreCustomer->zip_so) }}">
                                </div>
                                <div class="form-group">
                                    <select name="city_so" class="select2-city form-control">
                                        @if (old('city_so', $coreCustomer->city_so))
                                        <option value="{{ old('city_so', $coreCustomer->city_so) }}">{{ old('city_so',
                                            $coreCustomer->city_so) }}</option>
                                        @else
                                        <option></option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group prefix2">
                                    <input class="form-control" name="province_so" placeholder="Provincia"
                                        value="{{ old('province_so', $coreCustomer->province_so) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <input class="form-control" name="prefix_1"
                                        value="{{ old('prefix_1', $coreCustomer->prefix_1) }}">
                                </div>
                                <div class="form-group w-66">
                                    <input class="form-control" name="phone_1"
                                        value="{{ old('phone_1', $coreCustomer->phone_1) }}">
                                </div>
                                <div class="form-group w-50">
                                    <label>Tel. 2</label>
                                    <input class="form-control" name="prefix_2"
                                        value="{{ old('prefix_2', $coreCustomer->prefix_2) }}">
                                </div>
                                <div class="form-group w-66">
                                    <input type="text" class="form-control" name="phone_2"
                                        value="{{ old('phone_2', $coreCustomer->phone_2) }}">
                                </div>
                                <div class="form-group w-50">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" name="prefix_fax"
                                        value="{{ old('prefix_fax', $coreCustomer->prefix_fax) }}">
                                </div>
                                <div class="form-group w-66">
                                    <input class="form-control" name="fax" value="{{ old('fax', $coreCustomer->fax) }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ old('email', $coreCustomer->email) }}">
                                </div>
                                <div class="form-group">
                                    <label for="pec">PEC</label>
                                    <input type="email" name="pec" class="form-control" placeholder="PEC"
                                        value="{{ old('pec', $coreCustomer->pec) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <input class="form-control" name="rl_surname" placeholder="Cognome"
                                        value="{{ old('rl_surname', $coreCustomer->rl_surname) }}">
                                </div>
                                <div class="form-group">
                                    <input class="form-control mt-23" name="rl_name" placeholder="Nome"
                                        value="{{ old('rl_name', $coreCustomer->rl_name) }}">
                                </div>
                                <div class="form-group w-50">
                                    <label>Tel.</label>
                                    <input class="form-control" name="rl_prefix_1"
                                        value="{{ old('rl_prefix_1', $coreCustomer->rl_prefix_1)}}">
                                </div>
                                <div class="form-group w-66">
                                    <input class="form-control" name="rl_phone_1"
                                        value="{{ old('rl_phone_1', $coreCustomer->rl_phone_1) }}">
                                </div>
                                <div class="form-group w-50">
                                    <label>Tel. 2</label>
                                    <input class="form-control" name="rl_prefix_2"
                                        value="{{ old('rl_prefix_2', $coreCustomer->rl_prefix_2) }}">
                                </div>
                                <div class="form-group w-66">
                                    <input class="form-control" name="rl_phone_2"
                                        value="{{ old('rl_phone_2', $coreCustomer->rl_phone_2) }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="rl_email"
                                        value="{{ old('rl_email', $coreCustomer->rl_email) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="form-group">
                                    <label>Referente</label>
                                    <input class="form-control" name="referent_surname"
                                        value="{{ old('referent_surname', $coreCustomer->referent_surname) }}"
                                        placeholder="Cognome">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="referent_name"
                                        value="{{  old('referent_name', $coreCustomer->referent_name) }}"
                                        placeholder="Nome">
                                </div>
                                <div class="form-group w-50">
                                    <label>Tel.</label>
                                    <input type="text" class="form-control" name="referent_prefix_1"
                                        value="{{ old('referent_prefix_1', $coreCustomer->referent_prefix_1) }}">
                                </div>
                                <div class="form-group w-66">
                                    <input class="form-control" name="referent_phone_1"
                                        value="{{ old('referent_phone_1', $coreCustomer->referent_phone_1) }}">
                                </div>
                                <div class="form-group w-50">
                                    <label>Tel. 2</label>
                                    <input class="form-control" name="referent_prefix_2"
                                        value="{{  old('referent_prefix_2', $coreCustomer->referent_prefix_2)}}">
                                </div>
                                <div class="form-group w-66">
                                    <input type="text" class="form-control" name="referent_phone_2"
                                        value="{{ old('referent_phone_2', $coreCustomer->referent_phone_2) }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="referent_email"
                                        value="{{ old('referent_email', $coreCustomer->referent_email) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <a class="btn btn-warning pull-left" href="{{ route("core_customers.index") }}">
                        <i class="fas fa-times"></i> Annulla
                    </a>
                    <button class="btn btn-primary pull-right save_btn">
                        <i class="fas fa-save"></i> Salva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/js/core/libraries/jQuery.print.min.js"></script>
<script src="/js/core/libraries/bootstrap-datepicker.min.js"></script>
<script src="/js/core/core_customers/edit.js"></script>
@stop
