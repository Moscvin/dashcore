@extends('core.layouts.page')

@section('content_header')
    <h1>
        Eccezioni <small>Elenco dei users con eccezioni</small>
    </h1>
@stop

@section('css')
<style>
    select {
        width: 100% !important;
    }
</style>
@stop

@section('content')
    <div class="container-fluid spark-screen">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fas fa-check"></i> {{ Session::get('success') }}</h4>
            </div>
        @endif
        <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 id="entityTitle">Utenti con eccezioni</h3>

                        @if (in_array('A', $chars) || in_array('E', $chars))
                        <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" onchange="openEditUserPermissionsExceptionsPage(this)">
                                <option></option>
                                @foreach ($coreUsers as $coreUser)
                                <option value="{{ route('core_permissions_exceptions.editUserPermissionsExceptions', $coreUser)}}">
                                    {{ $coreUser->fullname }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        @endif
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered" id="table">
                              <thead>
                                <tr>
                                    <th>Utente</th>
                                    <th>Menu</th>
                                    <th>Autorizzazioni</th>
                                    @if (in_array('E', $chars))
                                        <th class='action_btn'></th>
                                    @endif
                                    @if (in_array('D', $chars))
                                        <th class='action_btn'></th>
                                    @endif
                                </tr>
                              </thead>
                              @foreach ($corePermissionsExceptions as $corePermissionEsception)
                                <tr>
                                    <td>{{ $corePermissionEsception->coreUser->fullName }}</td>
                                    <td>{{ $corePermissionEsception->coreMenu->description }}</td>
                                    <td>{{ $corePermissionEsception->permission }}</td>
                                    @if (in_array('E', $chars))
                                        <td>
                                            <a href='{{ route('core_permissions_exceptions.editUserPermissionsExceptions', $corePermissionEsception->core_user_id) }}' class='btn btn-xs btn-info' title='Modifica'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </td>
                                    @endif
                                    @if (in_array('D', $chars))
                                        <td>
                                            <button onclick='corePermissionEsceptionDeleteItem(this)' data-id='{{ $corePermissionEsception->id }}' type='button'
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
        <x-core.modals.modal-delete-item prefix='corePermissionEsception' action='eliminare il eccezioni' url='core_permission_exceptions' tableId='table' />
    @endif

@endsection

@section('js')
<script>
    const openEditUserPermissionsExceptionsPage = context => {
        window.location.href = context.value;
    }

    jQuery(document).ready(function () {
        $('#table').DataTable({
            dom:'lBfrtip',
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
