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

    <div class="modal" id="managerReservationUpdateItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-white">
                    <h3 class="modal-title">
                        Update Reservation
                    </h3>
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
                        onclick='submitForm("updateForm")'>
                        Salva
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const managerReservationUpdateItem = new bootstrap.Modal(document.getElementById(
            'managerReservationUpdateItem'), {});

        var submitForm = function() {
            submitFormAjax($(managerReservationUpdateItem._element).find('form')).then((response) => {
                managerReservationUpdateItem.hide();
                $(managerReservationUpdateItem._element).find('form').find(':input').val('');
                table.ajax.reload();
            });
        }

        var openManagerReservationUpdateItem = function(btn) {
            var data = JSON.parse(btn.dataset.word);
            console.log(data);
            const form = $(managerReservationUpdateItem._element).find('form');
            form.data('id', data.id);
            form.html('');

            form.append(`
         <div class="col-md-12">
    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" class="form-control">
            <option value="1" ${data.status === 1 ? 'selected' : ''}>Activ</option>
            <option value="0" ${data.status === 0 ? 'selected' : ''}>Inactiv</option>
        </select>

        <label for="username">Username</label>
        <input type="text" id="username" class="form-control" value="${data.core_user.username ?? 'Username not available'}" readonly>

        <label for="specialization">Specialization</label>
        <input type="text" id="specialization" class="form-control" value="${data.specialization.specialization_name ?? 'Specialization not available'}" readonly>

        <label for="doctor_name">Doctor Name</label>
        <select id="doctor_name" class="form-control">
            ${data.doctorsList?.filter(doctor => doctor.specialization_id === data.specialization.id)
                .map(doctor => `
                                <option value="${doctor.id}" ${doctor.id === data.doctor?.id ? 'selected' : ''}>
                                    ${doctor.name}
                                </option>
                            `).join('') ?? '<option>No doctors available</option>'}
        </select>

        <!-- Reservation Slots Dropdown -->
        <label for="reservation_slot">Reservation Slot</label>
        <select id="reservation_slot" class="form-control">
            ${data.reservation_slots?.map(slot => `
                            <option value="${slot.id}">
                                ${slot.time}
                            </option>
                        `).join('') ?? '<option>No reservation slots available</option>'}
        </select>
    </div>
</div>

            `);

            $(managerReservationUpdateItem._element).find('.modal-title').text(data.title);
            managerReservationUpdateItem.show();
        }

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
                                .getDate() + d.getHours() + d.getMinutes() + d.getSeconds();
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
