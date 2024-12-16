<?php 

namespace App\Traits\Core;

use App\Models\Core\CorePermission;
use App\Models\Core\CorePermissionException;

trait PermissionExceptionTrait
{
    public function hasPermission($menuId, $user): bool
    {
        $permissionException = CorePermissionException::where('core_menu_id', $menuId)->where('core_user_id', $user->id)->first();
        $hasPermission = false;
        
        if ($permissionException) {
            if (!empty($permissionException->permission)) {
                $hasPermission = true;
            }
        } else {
            $permission = CorePermission::where('core_menu_id', $menuId)->where('core_group_id', $user->core_group_id)->first();
            
            if (!empty($permission->permission)) {
                $hasPermission = true;
            }
        }

        return $hasPermission;
    }
}