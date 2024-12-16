@extends('core.layouts.page')


@section('content_header')
<h1>
    Indirizzi <small>Comuni</small>
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
                    <h3 id="entityTitle">Elenco dei comuni</h3>
                    @if (in_array('A', $chars))
                    <a class='btn btn-primary ' href='{{ route('core_cities.create') }}'>
                        <i class='fas fa-plus'></i> Nuovo Comune
                    </a>
                    @endif
                </div>

                <div class='box-body'>
                    <div class='table-responsive'>
                        <table class='table table-responsive table-bordered table-hover table-condensed' id='table'>
                            <thead>
                                <tr>
                                    <th>Comune</th>
                                    <th>CAP</th>
                                    <th>Provincia</th>
                                    @if (in_array('E', $chars))
                                    <th class='action_btn nosorting no-print'></th>
                                    @endif
                                    @if (in_array('D', $chars))
                                    <th class='action_btn nosorting no-print'></th>
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

@if (in_array('D', $chars))
<x-core.modals.modal-delete-item prefix='coreCity' action='eliminare il comune' url='core_cities' tableId='table' />
@endif
@endsection

@section('js')
<script>
    jQuery(document).ready(function () {
        $('#table').DataTable({
            dom:'lBfrtip',
            ajax: {
                url: '/core_cities/ajax'
            },
            paging: true,
            serverSide: true,
            processing: true,
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-success btn-sm',
                    text: '<i class="fas fa-download" title="Download"></i>',
                    title: $('#entityTitle').text(),
                    filename: function () {
                        var d = new Date();
                        var n = d.getFullYear() + '' + d.getMonth() + '' + d.getDate() + '' + d.getHours() + '' + d.getMinutes() + '' + d.getSeconds();
                        return document.title + '-' + n;
                    },
                },
                {
                    extend: 'print',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-print" title="stampa"></i>',
                    title: $('#entityTitle').text(),
                    exportOptions: {
                        columns: 'thead th:not(.action_btn)'
                    }
                }
            ],
            lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, 'tutti']],
            columnDefs: [
                { targets: 'action_btn', orderable: false }
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
            },
            columnDefs: [
                {
                    targets: 'action_btn', orderable: false
                },
                {
                    targets: 'action_btn', class: 'action_btn'
                }
            ],
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endsection