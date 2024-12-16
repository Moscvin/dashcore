<tr class="tr nivel_{{$nivel}} id_menu_item_{{$menu->id}} id_parent_{{$menu->parent_id}}">
    <td class="">{{$menu->description ?? ''}}</td>
        <?php $btn_status = 0;?>

            @if(count($permissionsexceptions) > 0)
                @foreach($permissionsexceptions as $core_premission)
                    @if(
                        !empty($core_premission->core_user_id) && $core_premission->core_user_id == $user->id
                        && $menu->id == $core_premission->core_menu_id
                    )

                        <?php $btn_status = 1;?>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="btn btn-xs app {{ !empty($core_premissio->permission) ? 'btn-danger' : 'btn-success'}} ">
                                        <i class="fa-solid fa-{{ !empty($core_premissio->permission) ? 'lock' : 'unlock'}}"></i>
                                    </i></span>
                                <input  type="text" class="form-control permission_exception_input" placeholder="Null" value="{{ $core_premission->permission ??  ''}}"
                                        data-id-perm-expt="{{$core_premission->id}}"
                                        data-id-men-item="{{$menu->id ?? 0}}"
                                        data-id-user="{{$user->id}}"
                                        data-perm="{{$core_premission->permission ?? ''}}"
                                      >
                            </div>
                        </td>

                    @endif
                @endforeach
            @endif

            @if (empty($btn_status))
                <?php
        $group_id = $user->coreGroup->id;
        $core_premission = \App\Models\Core\CorePermission::where('core_group_id',$group_id)->where('core_menu_id',$menu->id)->first();?>
                    <td>
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="btn btn-xs btn-danger">
                                        <i class="fa-solid fa-lock"></i>
                                    </i>
                                </span>
                        <input  type="text" class="form-control permission_exception_input isHanged" placeholder="Null"
                                data-id-men-item="{{$menu->id ?? 0}}"
                                data-id-user="{{$user->id}}"
                                data-perm=""
                                value="{{$core_premission->permission ?? ''}}"

                        >
                    </div>

                </td>
            @endif


</tr>
@if (count($menu->children) > 0)
    <?php $nivel .= 0; ?>
    @foreach($menu->children as $menu)
        @include('core.layouts.partials.permissions.exceptpermission', ['menu' => $menu,'permissionsexceptions'=> $permissionsexceptions, 'nivel' => $nivel])
    @endforeach
@endif
