@php
    $btn_status = false;
    $group_permission = $coreUser->coreGroup->permission;
@endphp

<tr class="tr nivel_{{$nivel}} core_menu_id_{{$coreMenu->id}} id_parent_{{$coreMenu->parent_id}}">
    <td>{{$coreMenu->description ?? ''}}</td>
    <td>
        @foreach($corePermissionsExceptions as $core_permission)
            @if(
                !empty($core_permission->core_user_id) && $core_permission->core_user_id == $coreUser->id &&
                $coreMenu->id == $core_permission->core_menu_id
            )
                @php $btn_status = true; @endphp
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="btn btn-xs btn-{{ $group_permission ? 'danger' : 'success' }}">
                            <i class="fa-solid fa-{{ $group_permission ? 'lock' : 'unlock' }}"></i>
                        </i>
                    </span>
                    <input type="text" class="form-control permission_input" placeholder="Null"
                           value="{{ $core_permission->permission ?? ''}}" 
                           data-l="{{ strlen($core_permission->permission) }}"
                           data-id-perm-expt="{{$core_permission->id }}"
                           data-id-men-item="{{$coreMenu->id ?? 0}}"
                           data-id-user="{{$coreUser->id}}"
                           data-perm="{{$core_permission->permission ?? ''}}">
                </div>
            @endif
        @endforeach

        @if (!$btn_status)
            @php
                $group_id = $coreUser->coreGroup->id;
                $core_permission = \App\Models\Core\CorePermission::where('id', $group_id)
                                    ->where('core_menu_id', $coreMenu->id)->first();
                $permission = $core_permission->permission 
                              ?? $corePermissions->firstWhere('core_menu_id', $coreMenu->id)->permission 
                              ?? '';
            @endphp
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="btn btn-xs btn-{{ $group_permission || $permission != '' ? 'success' : 'danger' }}">
                        <i class="fa-solid fa-{{ $group_permission || $permission != ''  ? 'unlock' : 'lock' }}"></i>
                    </i>
                </span>
                <input type="text" class="form-control permission_input" placeholder="Null"
                       data-id-men-item="{{$coreMenu->id ?? ''}}"
                       data-id-user="{{$coreUser->id ?? ''}}"
                       data-perm=""
                       value="{{ $permission }}">
            </div>
        @endif
    </td>
</tr>

@if ($coreMenu->children->isNotEmpty())
    @foreach($coreMenu->children as $childMenu)
        @include('core.permissions_exceptions.parts.item', [
            'coreUser' => $coreUser,
            'coreMenu' => $childMenu,
            'corePermissionsExceptions'=> $corePermissionsExceptions,
            'nivel' => $nivel + 1
        ])
    @endforeach
@endif
