@extends('core.layouts.page')

@section('content_header')
    <h1>
        Autorizzazioni <small>Elenco delle autorizzazioni</small>
    </h1>
@stop

@section('css')
@stop

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3>Elenco delle autorizzazioni per {{ $coreUser->username ?? ''}}</h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-hover table-condensed" id="permission_list_table">
                                <thead>
                                    <tr>
                                        <th>Voce menu</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($coreMenus))
                                    @foreach($coreMenus as $coreMenu)
                                        @include('core.permissions_exceptions.parts.item', [
                                            'coreUser' => $coreUser,
                                            'coreMenu' => $coreMenu,
                                            'corePermissionsExceptions'=> $corePermissionsExceptions,
                                            'nivel' => 0
                                        ])
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <a class="btn btn-warning pull-left"  href="{{ route("core_permissions_exceptions.index") }}">
                                <i class="fas fa-times"></i> Annulla
                            </a>
                            <button id="save_data" class="btn btn-primary pull-right">
                                <i class="fas fa-save"></i> Salva
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(document).ready(function () {
            var data_permission_exceptions = [];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.permission_input').keyup(function(){
                this.value = this.value.toUpperCase().replace(/[^a-z]/gi,'');
                $(this).addClass('isHanged');
            });

            function hasWhiteSpace(s) {
                return /\s/g.test(s);
            }


            $('#save_data').click(function () {
                console.log(1);
                $('.isHanged').each(function () {
                    var data  = new Object;
                    data.id_perm_expt = parseInt($(this).attr("data-id-perm-expt"));
                    data.core_menu_id = parseInt($(this).attr("data-id-men-item"));
                    data.core_user_id = parseInt($(this).attr("data-id-user"));

                    if (hasWhiteSpace($(this).val())){
                        data.permission = '';
                    }else{
                        data.permission = $(this).val();
                    }

                    data_permission_exceptions.push(data);
                });

                $.ajax({
                    url: '/core_permissions_exceptions/' + {{ $coreUser->id }},
                    type : 'PATCH',
                    data:{permission:JSON.stringify(data_permission_exceptions)},
                    dataType:'json',
                    success: function(data){
                        window.location.href = "/core_permissions_exceptions";
                    },
                });
                return true;

            });
        });
    </script>
@endsection
