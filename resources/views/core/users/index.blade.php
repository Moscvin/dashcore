@extends('core.layouts.page')

@section('content_header')
    <h1>
        Utenti <small>Elenco utenti</small>
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
    <div class='container-fluid spark-screen'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='box box-primary'>
                    <div class='box-header with-border'>
                        @if (Session::has('success'))
                            <div class='alert alert-success alert-dismissible'>
                                <h4><i class='icon fas fa-check'></i> {{ Session::get('success') }}</h4>
                            </div>
                        @endif
                        <h3 id="entityTitle">Elenco degli utenti</h3>
                         @if(in_array('A', $chars))
                            <a class='btn btn-primary'  href='{{ route('core_users.create') }}'>
                                <i class='fas fa-plus'></i> Nuovo utente
                            </a>
                         @endif
                    </div>
                    <div class='box-body'>
                        <div class='table-responsive'>
                            <table class='table table-responsive stripe' id='table'>
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Cognome</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Gruppo</th>
                                        <th data-visible="false">Attivo</th>
                                        @if (in_array('E', $chars))
                                            <th class='action_btn'></th>
                                        @endif
                                        @if (in_array('V', $chars))
                                            <th class='action_btn'></th>
                                        @endif
                                        @if (in_array('L', $chars))
                                            <th class='action_btn'></th>
                                        @endif
                                        @if (in_array('D', $chars))
                                            <th class='action_btn'></th>
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
        <x-core.modals.modal-lock-item prefix='coreUser' url='core_users' />
    @endif

    @if (in_array('D', $chars))
        <x-core.modals.modal-delete-item prefix='coreUser' action='eliminare il utente' url='core_users' tableId='table' />
    @endif
@endsection

@section('js')
    <script>
        jQuery(document).ready(function () {
            $('#table').DataTable({
                dom: 'lBfrtip',
                ajax: {
                    url: '/core_users/ajax'
                },
                paging: true,
                serverSide: true,
                processing: true,
                "createdRow": function( row, data, dataIndex){
                    if( data[5] !== 1 ){
                        $(row).addClass('locked');
                    }
                },
                buttons: [
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="fas fa-download" title="Download"></i>',
                        title: $('#entityTitle').text(),
                        exportOptions: {
                            columns: 'thead th:not(.action_btn)'
                        },
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
                        },
                    }
                ],
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, 'tutti']],
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
