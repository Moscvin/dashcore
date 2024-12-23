@extends('core.layouts.page')

@section('content_header')
    <h1>
        Reservation <small>Gestione</small>
    </h1>
@stop

@section('css')
    <style>
        .locked {
            background-color: #f6aeae !important;
            color: #111111 !important;
        }

        .unlocked {
            background-color: #a3f6ae !important;
            color: #111111 !important;
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
                                <a class="btn btn-primary" href="{{ route('manager_reservation.create') }}">
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
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Doctor</th>
                                        <th>Specialization</th>
                                        @if (isset($showTimeColumn) && $showTimeColumn)
                                            <th>Time</th>
                                        @endif
                                        @if (in_array('V', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                        @if (in_array('E', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                        <th class="action_btn nosorting"></th>
                                        @if (in_array('L', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                        @if (in_array('D', $chars))
                                            <th class="action_btn nosorting"></th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (in_array('L', $chars))
        <x-core.modals.modal-lock-item prefix='manager_reservation' url='manager_reservation' />
    @endif

    @if (in_array('D', $chars))
        <x-core.modals.modal-delete-item prefix='manager_reservation' action='eliminare rezervare' url='manager_reservation'
            :tableId="'table'" />
    @endif
    <div class="modal" id="translationsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-white">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form>
                        </form>
                    </div>
                </div>
                <div class="modal-footer" style="display: block">
                    <button type="button" class="btn btn-warning pull-left" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>&nbsp;Annulla
                    </button>
                    <button type="button" class="btn btn-success pull-right" id="delete-btn" data-bs-dismiss="modal"
                        onclick='submitTranslations()'>
                        Salva
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var manager_reservationUpdateItem = function(btn) {
            var data = JSON.parse(btn.dataset.word);
            console.log(data);
            const form = $(translationsModal._element).find('form');
            form.data('id', data.id_word);
            form.html('');
            data.languages.forEach((item) => {

                form.append(`
                    <div class="row form-group">
                        <div class="col-md-2">
                            <div style='margin-top:8px;'>
                                <label>${item.acronym}</label>
                                <img src="${item.file_route}">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control w-100" name="translations[${item.id_language}]" value="${item.translation.text}">
                        </div>
                    </div>
                `);
            });

            $(translationsModal._element).find('h3.modal-title').text('Traduzione ' + data.text);
            translationsModal.show();
        };
        $(document).ready(function() {
            $('#table').DataTable({
                dom: "lBrtip",
                ajax: {
                    url: '/manager_reservation/ajax',
                },
                paging: true,
                serverSide: true,
                processing: true,
                createdRow: function(row, data, dataIndex) {
                    if (data['active'] != 1) {
                        $(row).addClass('locked');
                    } else {
                        $(row).addClass('unlocked');
                    }
                },
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
