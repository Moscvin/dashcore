@extends('core.layouts.page')

@section('content_header')
    <h1>Menu
        <small>Elenco menu</small></h1>
@stop

{{-- @include('helpers.parent_if') --}}

@section('content')

    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-solid box-primary">
                        <div class="box-header with-border">Menu
                            <section style="padding-bottom: 30px;">
                                <a class="pull-left btn btn-default btn-flat" href="{{ "/core_menu" }}"><- Back</a>
                                {{-- <a class="pull-right btn btn-success btn-flat" href="{{ "/core_menu_add" }}">Add item menu</a> --}}
                            </section>
                        </div>
                        <div class="box-body">
                            @if($pages)
                                @foreach($pages as $page)
                                @endforeach
                            @endif

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- {!! Form::open(array('url' => '#', 'method' => 'post', 'files' => true, 'enctype' => 'multipart/form-data'))  !!} --}}
                        <form method="POST" action="core_menu"></form>
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="description">Description</label>
                                    <input class="form-control" id="description" type="text" name="description" value="{{$page->description ?? ''}}" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="link">Link</label>
                                    <input class="form-control" id="link" type="text" name="link" value="{{$page->link ?? ''}}" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="list_order">List order</label>
                                    <input class="form-control" id="list_order" type="number" name="list_order" value="{{$page->list_order ?? ''}}" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_parent">Parent</label>
                                    <select name="id_parent" class="form-control">
                                        <option value="0" >-Select-</option>
                                        @if($menus_c)
                                            @foreach($menus_c as $menu)
                                                <option
                                                        @if(!empty($page) && $menu['id'] == $page->id_parent) selected="selected" @endif
                                                        value="{{$menu['id']}}" >{{$menu['description']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="icon">Icon</label>
                                    <input class="form-control" id="icon" type="text" name="icon" value="{{$page->icon ?? ''}}" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="filterss">Permission</label>
                                        <?php
                                        if($pages && count($page->core_permission) > 0){
                                            $project_atributs = $page->core_permission->toArray();
                                        }
                                        if(empty($project_atributs)){
                                            $project_atributs[] = [
                                                'id_permission' => '',
                                                'id_menu_item' => '',
                                                'id_group' => '',
                                            ];
                                        }
                                        ?>
                                        <div class="filters_group">
                                            @foreach($project_atributs as $kkey => $atrib)
                                                <div class="row filters" data-attr-id="{{$atrib['id_permission']}}">
                                                    <div class="col-md-12">
                                                        <select name="id_group[{{$atrib['id_permission']}}][]" class="attr-role form-control a1">
                                                            <option value="0" >- select -</option>
                                                            @if($roles2)
                                                                @foreach($roles2 as $item)
                                                                    <option @if($atrib['id_group'] == $item->id_group) selected='selected' @endif value="{{ $item->id_group ?? "" }}"> {{ $item->description ?? "" }} </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @if($kkey > 0)
                                                        <span class="minusAttach"><i class="fas fa-minus" aria-hidden="true"></i></span>
                                                    @endif
                                                </div>
                                                @if($kkey == 0)
                                                    <span id="plusAttach2"><i class="fas fa-plus" aria-hidden="true"></i></span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group @if(!$pages) col-md-12 @else col-md-8 @endif ">
                                    <input class="form-control btn btn-success btn-flat" type="submit" name="save" id="save" value="Save">
                                </div>
                                @if($pages)
                                    <div class="form-group col-md-4">
                                        <a onclick="return confirm('Are you sure?')" href="{{ "/core_menu_del" }}/{{$page->id_menu_item}}" class="form-control btn btn-danger btn-flat" >Sterge</a>
                                    </div>
                                @endif
                            </div>
                            
                        </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>
@endsection

@push('js')
        <script>
            $(function() {
                $( "#plusAttach2" ).click(function() {
                    var liData = $( ".filters_group .filters:first").clone();
                    var liMinus = '<span class="minusAttach"><i class="fas fa-minus" aria-hidden="true"></i></span>';
                    $(".filters_group").append(liData);
                    $(".filters_group .filters:last").append(liMinus);
                    $(".filters_group .filters:last").attr('data-attr-id', "0");
                    $(".filters_group .filters:last").find(".a1").attr('name', "id_group[][]");
                });
                $(document).on("click",".filters_group .minusAttach",function() {
                    $thismy = $( this );
                    $( this ).parent().slideUp(300, function(){
                        $thismy.parent().remove();
                    });

                    var iidd_attr = $thismy.parent().attr('data-attr-id');
                    if(iidd_attr != "" && iidd_attr != "0" && iidd_attr > 0){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/del_role_permision',
                            type: 'POST',
                            data:{ iidd_attr: iidd_attr },
                            dataType: 'json',
                            success: function(data) {
                                //alert('yes')
                            }
                        });
                        return true;
                    }
                });

            });
        </script>
@endpush
