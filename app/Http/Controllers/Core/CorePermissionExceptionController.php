<?php

namespace App\Http\Controllers\Core;


use Illuminate\Http\Request;
use App\Models\Core\CoreUser;
use App\Models\Core\CorePermission;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Models\Core\CoreMenu;
use Illuminate\Support\Facades\Auth;
use App\Models\Core\CorePermissionException;

class CorePermissionExceptionController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');
    
        $coreUsers = CoreUser::orderBy('name')->orderBy('surname')->get();
        $corePermissionsExceptions = CorePermissionException::get()->unique("core_user_id");

    
        return view('core.permissions_exceptions.index', compact('corePermissionsExceptions', 'coreUsers'));
    }
    

    public function editUserPermissionsExceptions(CoreUser $coreUser)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreMenus = CoreMenu::tree();
        $corePermissions = CorePermission::where('core_group_id', $coreUser->core_group_id)->get();
        $corePermissionsExceptions = CorePermissionException::where('core_user_id', $coreUser->id)->get();

        return view('core.permissions_exceptions.create', compact(
            'coreUser', 'coreMenus', 'corePermissions', 'corePermissionsExceptions'
        ));
    }

    public function update(Request $request, CoreUser $coreUser)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');


        $permissions_exception = json_decode($request->permission);

        foreach ($permissions_exception as $permission) {

            $permission_value = trim($permission->permission);
            $id_user = trim($permission->core_user_id);
            $id_menu_item = trim($permission->core_menu_id);

            $corePermission = CorePermission::where('core_group_id', $coreUser->core_group_id)->where('core_menu_id', $permission->core_menu_id)->first();


            $permission_current = CorePermissionException::where("core_menu_id", $id_menu_item)
                ->where("core_user_id", $coreUser->id_user)
                ->first();

            if($corePermission->permission != $permission_value ){
                $data = [
                    'permission' => $permission_value,
                    'core_user_id' => $id_user,
                    'core_menu_id' => $id_menu_item,
                ];

                if (!$permission_current) {
                    CorePermissionException::create($data);
                    
                } elseif($permission_current && $permission_value == "") {
                    $permission_current->delete();
                } 
                else {
                    CorePermissionException::where([
                        'id_permission_exception' => $permission->id_perm_expt,
                        'core_menu_id' => $id_menu_item,
                        'core_user_id' => $id_user,
                    ])->update(['permission' => $permission_value]);
                }
            } else {
                $permission_current->delete();
            }
        }

        Session::flash('success', 'Eccezioni salvati con successo!');
        return response()->json(['status'=>true], 200);
    }
    
    public function destroy($permission)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');
        CorePermissionException::where('id', $permission)->delete();
        return response()->json(['status' => 'Success', 204]);
    }
}
