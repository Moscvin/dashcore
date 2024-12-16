<tr class="tr nivel_{{$nivel}} id_menu_item_{{$coreMenu->id_menu_item}} id_parent_{{$coreMenu->id_parent}}">
    <td class="">{{$coreMenu->description ?? ''}}</td>

    @foreach($coreGroups as $coreGroup)
        <?php $btn_status = 0;?>
        <td>
            @if(count($coreMenu->corePermissions) > 0)
                @foreach($coreMenu->corePermissions as $corePermission)
                    @if(
                        !empty($corePermission->core_group_id) && $corePermission->core_group_id == $coreGroup->id
                        && $coreMenu->id == $corePermission->core_menu_id
                        && !empty($corePermission->permission)
                    ) <?php $btn_status = 1;?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="btn btn-xs fa-regular btn-{{ !empty($coreGroup->permission) ? 'danger' : 'success'}} fa-regular ">
                                    <i class="fa-solid fa-{{ empty($coreGroup->permission) ? 'unlock' : ''}}"></i>
                                </i>
                            </span>
                            <input type="text" class="form-control permission_input" placeholder="Null"
                                    value="{{ $corePermission->permission ?? ''}}" data-l="{{ strlen($corePermission->permission) }}"
                                    data-id="{{$corePermission->id ?? 0}}" data-group="{{$coreGroup->id ?? 0}}" data-menu="{{$coreMenu->id ?? 0}}">
                        </div>
                    @endif
                @endforeach
            @endif

            @if (empty($btn_status))
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="btn btn-xs fa-regular btn-{{ empty($coreGroup->permission) ? 'danger' : 'success'}} ">
                            <i class="fa-solid fa-{{ empty($coreGroup->permission) ? 'lock' : ''}}"></i>
                        </i>
                    </span>
                    <input type="text" class="form-control permission_input" value="" placeholder="Null"
                            data-id="0" data-group="{{$coreGroup->id ?? 0}}" data-menu="{{$coreMenu->id ?? 0}}" >
                </div>
            @endif
        </td>
    @endforeach
</tr>
@if (count($coreMenu->children) > 0)
    <?php $nivel .= 0; ?>
    @foreach($coreMenu->children as $coreMenu)
        @include('core.permissions.parts.item', ['coreMenu' => $coreMenu, 'coreGroups' => $coreGroups, 'nivel' => $nivel])
    @endforeach
@endif

