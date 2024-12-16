@extends('core.layouts.page')

@section('content_header')
<h1>
    Menu <small>Elenco menu</small>
</h1>
@stop

@section('content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <section style="padding-bottom: 30px;">
                            <a class="pull-left btn btn-default btn-flat" href="{{ route('core_menus.index') }}">
                                <i class="fas fa-refresh"></i> Refresh
                            </a>
                        </section>
                    </div>
                    <div class="box-body">
                        <div class="panel-body" id="cont">
                            <ul id="menuEditor" class="sortableLists list-group">
                            </ul>
                        </div>
                        <button id="btnOut" type="button" class="btn btn-success">
                            <i class="glyphicon glyphicon-ok"></i>
                            <span class="saveMenusBtn">Save</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <section style="padding-bottom: 30px;">
                            <button type="button" id="btnAdd" class="pull-right btn btn-success btn-flat">
                                <i class="fas fa-plus"></i> Add
                            </button>

                            <button type="button" id="btnUpdate" class="pull-left btn btn-default btn-flat" disabled>
                                <i class="fas fa-refresh"></i> Update
                            </button>
                        </section>
                    </div>
                    <div class="box-body">
                        <form id="formEdit" class="form-horizontal">
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-6">
                                    <div>
                                        <input type="text" class="form-control item-menu" name="description"
                                            id="description" placeholder="Text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div>
                                        <input type="text" class="form-control item-menu" name="icon" id="icon"
                                            placeholder="Icon">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="href" class="col-sm-2 control-label">Link</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control item-menu" id="link" name="link"
                                        placeholder="URL">
                                </div>
                                <div class="col-sm-4">
                                    <div>
                                        <select name="show" class="form-control item-menu"
                                            style="width: 100% !important">
                                            <option value="" disabled>Mostra menu</option>
                                            <option value="0">No</option>
                                            <option value="1" selected>Si</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/menu/menu_editor.js') }}"></script>
<script src="{{ asset('js/menu/iconset.min.js') }}"></script>
<script src="{{ asset('js/menu/bootstrap-iconpicker.min.js') }}"></script>
<script src="{{ asset('js/menu/init_menu.js') }}"></script>
@endsection