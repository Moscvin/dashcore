@extends('core.layouts.page')

@section('content_header')
    <h1>
        Doctor Specializations <small>Elenco delle specializzazioni dei doctor</small>
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
                        <h3 id="entityTitle">Elenco delle specializzazioni dei doctor</h3>

                        @if (in_array('A', $chars))
                            <a href='{{ route('doctor_specialization.create') }}' class='btn btn-primary'>
                                <i class='fas fa-plus'></i> Nuova Specializzazione
                            </a>
                        @endif
                    </div>

                    <div class='box-body'>
                        <div class='table-responsive'>
                            <table class='table table-responsive table-bordered' id='table'>
                                <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Specialization</th>
                                        @if (in_array('E', $chars))
                                            <th class='action_btn'></th>
                                        @endif
                                        @if (in_array('D', $chars))
                                            <th class='action_btn'></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctorSpecializations as $doctorSpecialization)
                                        <tr>
                                            <td>{{ $doctorSpecialization->doctor->name ?? 'No Doctor' }}</td>
                                            <td>{{ $doctorSpecialization->specialization->specialization_name ?? 'No Specialization' }}
                                            </td>
                                            @if (in_array('E', $chars))
                                                <td>
                                                    <a href='{{ route('doctor_specialization.edit', $doctorSpecialization->id) }}'
                                                        class='btn btn-xs btn-info' title='Modifica'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                </td>
                                            @endif
                                            @if (in_array('D', $chars))
                                                <td>
                                                    <button onclick='doctorSpecializationDeleteItem(this)'
                                                        data-id='{{ $doctorSpecialization->id }}' type='button'
                                                        class='action_del btn btn-xs btn-danger' title='Elimina'>
                                                        <i class='fa fa-trash'></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (in_array('D', $chars))
        <x-core.modals.modal-delete-item prefix='doctorSpecialization' action='eliminare il doctor' url='doctor_specialization'
            tableId='table' />
    @endif
@endsection

@section('js')
    <script>
        jQuery(document).ready(function() {
            $('#table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="fas fa-download" title="Download"></i>',
                        title: $('#entityTitle').text(),
                        exportOptions: {
                            columns: 'thead th:not(.action_btn)'
                        },
                        filename: function() {
                            var d = new Date();
                            var n = d.getFullYear() + '' + d.getMonth() + '' + d.getDate() + '' + d
                                .getHours() + '' + d.getMinutes() + '' + d.getSeconds();
                            return document.title + '-' + n;
                        },
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm',
                        text: '<i class="fas fa-print" title="Stampa"></i>',
                        title: $('#entityTitle').text(),
                        exportOptions: {
                            columns: 'thead th:not(.action_btn)'
                        },
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 250, 500, 1000, -1],
                    [10, 25, 50, 100, 250, 500, 1000, 'Tutti']
                ],
                columnDefs: [{
                    targets: 'action_btn',
                    orderable: false
                }],
                language: {
                    decimal: '',
                    emptyTable: 'Nessun dato disponibile',
                    info: 'Righe _START_ - _END_ di _TOTAL_ totali',
                    infoEmpty: 'Nessun record',
                    infoFiltered: '(su _MAX_ righe complessive)',
                    thousands: ',',
                    lengthMenu: 'Mostra _MENU_ righe',
                    loadingRecords: '...',
                    processing: '...',
                    search: 'Cerca:',
                    zeroRecords: 'Nessun dato corrisponde ai criteri impostati',
                    paginate: {
                        first: 'Primo',
                        last: 'Ultimo',
                        next: 'Succ.',
                        previous: 'Prec.'
                    }
                },
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection
