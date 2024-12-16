<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Models\Core\CoreGroup;
use App\Models\Core\CoreMenu;
use App\Models\Core\CorePermission;
use Illuminate\Http\Request;

class CorePermissionController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $this->data['coreMenus'] = CoreMenu::tree();
        $this->data['coreGroups'] = CoreGroup::get();
        return view('core.permissions.index', $this->data);
    }

    public function update(Request $request)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $permissions = json_decode($request->permission);

        foreach ($permissions as $permission) {

            $data = [
                'permission' => $permission->value,
                'core_group_id' => $permission->group,
                'core_menu_id' => $permission->menu,
            ];

            if ($permission->id == 0) {
                $permission_old = CorePermission::where('core_group_id', $permission->group)->where('core_menu_id', $permission->menu)->first();

                if ($permission_old) {
                    $permission_old->update(['permission' => $permission->value]);
                } else {
                    CorePermission::create($data);
                }
            } else {
                CorePermission::find($permission->id)->update(['permission' => $permission->value]);
            }
        }
        return response()->json(array('statut' => 'ok'), 200);
    }
}
