@extends('core.layouts.page')

@section('content_header')
<h1>
    Clienti <small>Gestione</small>
</h1>
@stop

@section('css')
<style>
    .locked {
        background-color: #222d321c !important;
        color: #a7a7a7 !important;
    }
</style>
@stop

@section('content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 id="entityTitle">Elenco clienti</h3>
                    @if(in_array('A', $chars))
                    <div>
                        <a class="btn btn-primary" href="{{ route('core_customers.create') }}">
                            <i class="fas fa-plus"></i> Nuovo Cliente
                        </a>
                    </div>
                    @endif
                </div>
                <div class="box-body">
                    <form class="form-inline filter">
                        <div class="form-group">
                            <label class="hidden">Field</label>
                            <select name="fieldFilter" class="form-control">
                                <option value="company_name">Denominazione</option>
                                <option value="vat">Partita Iva</option>
                                <option value="code_fiscal">Codice Fiscale</option>
                                <option value="city_sl">Comune</option>
                                <option value="phone_1">Telefono</option>
                                <option value="province_sl">Provincia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="valueFilter" class="select2-city form-control" onchange="filterTable()"
                                style="width: 300px">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group filter-buttons">
                            <button class="btn btn-success" type="button" onclick="filterTable()">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="/{{Request::path()}}" class="btn btn-danger" style="margin-left: auto;">
                                <i class="fas fa-sync-alt" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-responsive stripe" id="table">
                            <thead>
                                <tr>
                                    <th>Denominazione</th>
                                    <th>Partita IVA</th>
                                    <th>Codice Fiscale</th>
                                    <th>Comune</th>
                                    <th>Telefono</th>
                                    @if (in_array("V", $chars))
                                    <th class="action_btn nosorting"></th>
                                    @endif
                                    @if (in_array("V", $chars))
                                    <th class="action_btn nosorting"></th>
                                    @endif
                                    @if (in_array("E", $chars))
                                    <th class="action_btn nosorting"></th>
                                    @endif
                                    @if (in_array("L", $chars))
                                    <th class="action_btn nosorting"></th>
                                    @endif
                                    @if (in_array("D", $chars))
                                    <th class="action_btn nosorting"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (in_array('L', $chars))
<x-core.modals.modal-lock-item prefix='coreCustomer' url='core_customers' />
@endif

@if (in_array('D', $chars))
<x-core.modals.modal-delete-item prefix='coreCustomer' action='eliminare il cliente' url='core_customers'
    tableId='table' />
@endif

@endsection

@section('js')
<script>
    const filterTable = () => {
        const table = $('#table').DataTable();
        table.draw();
    }

    $(`[name=valueFilter]`).select2({
        theme: "dashcore",
        minimumInputLength: 1,
        language: "it",
        allowClear: true,
        ajax: {
            url: "/filters/customers/fields",
            dataType: "json",
            data: (params) => {
                const query = {
                    value: params.term,
                    field: document.querySelector('[name=fieldFilter]').value,
                };
                return query;
            },
        },
        placeholder: "Comune",
    });

    $(document).ready(function () {
        $('#table').DataTable({
            dom: "lBrtip",
            ajax: {
                url: '/core_customers/ajax',
                data: query => {
                    query.fieldFilter = document.querySelector('[name=fieldFilter]').value;
                    query.valueFilter = document.querySelector('[name=valueFilter]').value;
                    return query;
                }
            },
            drawCallback:function(){
                var btn = $('.action_block');
                $.each(btn, function(key, val) {
                    if($(val).hasClass("btn-primary")) {
                        $(val).closest('td').closest('tr').addClass("locked");
                    }
                });
            },
            paging: true,
            serverSide: true,
            processing: true,
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-success btn-sm',
                    text: "<i class='fas fa-download' title='Download'></i>",
                    title: $('#entityTitle').text(),
                    exportOptions: {
                        columns: 'thead th:not(.action_btn)'
                    },
                    filename: function () {
                        var d = new Date();
                        var n = d.getFullYear() + "" + d.getMonth() + "" + d.getDate() + "" + d.getHours() + "" + d.getMinutes() + "" + d.getSeconds();
                        return document.title + "-" + n;
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-primary btn-sm',
                    text: "<i class='fas fa-print' title='stampa'></i>",
                    title: $('#entityTitle').text(),
                    exportOptions: {
                        columns: 'thead th:not(.action_btn)'
                    },
                }

            ],
            lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "tutti"]],
            columnDefs: [
                {
                    targets: 'action_btn', orderable: false
                },
                {
                    targets: 'action_btn', class: 'action_btn'
                }
            ],
            language: {
                decimal: '',
                emptyTable: 'Nessun dato disponibile',
                info: 'Righe _START_ - _END_ di _TOTAL_ totali',
                infoEmpty: 'Nessun record',
                infoFiltered: '(su _MAX_ righe complessive)',
                infoPostFix: '',
                thousands: ',',
                lengthMenu: 'Mostra _MENU_ righe',
                loadingRecords: '...',
                processing: '...',
                search: 'Cerca:',
                zeroRecords: 'Nessun dato corrisponde ai criteri impostati',
                sLoadingRecords: '<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                paginate: {
                    first: 'Primo',
                    last: 'Ultimo',
                    next: 'Succ.',
                    previous: 'Prec.'
                }
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
@endsection