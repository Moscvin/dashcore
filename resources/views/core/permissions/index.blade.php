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
                        <h3>Elenco delle autorizzazioni</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-hover" id="permission_list_table">
                                <thead>
                                    <tr>
                                        <th>Voce menu</th>
                                        @foreach($coreGroups as $coreGroup)
                                            <th>{{ $coreGroup->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($coreMenus))
                                        @foreach($coreMenus as $coreMenu)
                                            @include('core.permissions.parts.item', ['coreMenu' => $coreMenu, 'coreGroup' => $coreGroup, 'nivel' => 0])
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                        </div>
                        <button class="btn btn-success pull-right" id="sava_data"><i class="fas fa-save"></i>&nbsp;Salva</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(function() {
            var btn;
            var data_permission;
            data_permission = [];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.permission_input').keyup(function() {
                this.value = this.value.toUpperCase().replace(/[^a-z]/gi,'');
                $(this).addClass('isHanged');
            });

            function hasWhiteSpace(s) {
                return /\s/g.test(s);
            }

            $('#sava_data').click(function() {
                $('.isHanged').each(function() {
                    var data  = new Object;
                    data.id = $(this).attr('data-id');
                    data.group = $(this).attr('data-group');
                    data.menu = $(this).attr('data-menu');
                    if(hasWhiteSpace($(this).val())) {
                        data.value = '';
                    } else {
                        data.value = $(this).val();
                    }

                    data_permission.push(data);
                });

                $.ajax({
                    url: '{{ route('core_permissions_general.update') }}',
                    type: 'POST',
                    data:{permission:JSON.stringify(data_permission)},
                    dataType:'json',
                    success: function(data){
                        window.location.reload(true);
                    }
                });
                return true;
            });
        });
    </script>
@endsection
