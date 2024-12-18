@extends('core.layouts.page')

@section('content_header')
    <h1>
        Reservation <small>Gestione</small>
    </h1>
@stop

@section('css')
    <style>
        .locked {
            background-color: #f5f5f5 !important;
            color: #a7a7a7 !important;
        }

        .btn-action {
            margin-right: 5px;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 id="entityTitle">Elenco Reservation</h3>
                        @if (in_array('A', $chars))
                            <div>
                                <a class="btn btn-primary" href="{{ route('core_reservations.create') }}">
                                    <i class="fas fa-plus"></i> Nuovo Reservation
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-responsive stripe" id="table">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Doctor</th>
                                        <th>Specialization</th>
                                        <th>Time</th>
                                        @if (in_array('V', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                        @if (in_array('E', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                        @if (in_array('L', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                        @if (in_array('D', $chars))
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
        <x-core.modals.modal-lock-item prefix='reservation' url='core_reservations' />
    @endif

    @if (in_array('D', $chars))
        <x-core.modals.modal-delete-item prefix='reservation' action='eliminare rezervare' url='core_reservations'
            :tableId="'table'" />
    @endif
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                dom: "lBrtip",
                ajax: {
                    url: '/core_reservations/ajax',
                },
                paging: true,
                serverSide: true,
                processing: true,
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: "<i class='fas fa-download' title='Download'></i>",
                        title: $('#entityTitle').text(),
                        exportOptions: {
                            columns: 'thead th:not(.action_btn)'
                        },
                        filename: function() {
                            const d = new Date();
                            return document.title + '-' + d.getFullYear() + (d.getMonth() + 1) + d
                                .getDate() +
                                d.getHours() + d.getMinutes() + d.getSeconds();
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm',
                        text: "<i class='fas fa-print' title='stampa'></i>",
                        title: $('#entityTitle').text(),
                        exportOptions: {
                            columns: 'thead th:not(.action_btn)'
                        }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 250, 500, 1000, -1],
                    [10, 25, 50, 100, 250, 500, 1000, "Tutti"]
                ],
                columnDefs: [{
                        targets: 'action_btn',
                        orderable: false
                    },
                    {
                        targets: 'action_btn',
                        class: 'action_btn'
                    }
                ],
                language: {
                    decimal: '',
                    emptyTable: 'Nessun dato disponibile',
                    info: 'Righe _START_ - _END_ di _TOTAL_ totali',
                    infoEmpty: 'Nessun record',
                    infoFiltered: '(su _MAX_ righe complessive)',
                    lengthMenu: 'Mostra _MENU_ righe',
                    loadingRecords: 'Caricamento...',
                    processing: 'Elaborazione...',
                    zeroRecords: 'Nessun dato corrisponde ai criteri impostati',
                    paginate: {
                        first: 'Primo',
                        last: 'Ultimo',
                        next: 'Succ.',
                        previous: 'Prec.'
                    }
                }
            });
        });
    </script>
@endsection
