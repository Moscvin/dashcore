<?php

namespace App\Http\Middleware;

use App\Models\Core\CoreMenu;
use App\Models\Core\CorePermission;
use App\Models\Core\CorePermissionException;
use App\Models\Core\CoreUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->isFallback) {
            if (Auth::guest()) {
                return redirect()->route('login');
            }
            abort(404);
        }

        if (!Auth::guest() && $request->path() != '/no_permission') {

            if (!Auth::user()->active) {
                Auth::logout();
                return redirect('/');
            }

            $user_id = Auth::id();

            $route_name = explode('.', $request->route()->getName())[0];
            $core_menu = CoreMenu::where('link', $route_name)->orWhere('link', 'like', '%' . $route_name)->get();

            if (!$core_menu->count()) {
                return $next($request);
            }

            $menu_id = $core_menu->first()->id;

            $permissionEx = CorePermissionException::where('core_menu_id', $menu_id)->where('core_user_id', $user_id)->get();

            if ($permissionEx->count()) {
                $permissionEx = $permissionEx->first();

                if (empty($permissionEx->permission)) {
                    return redirect('/no_permission');
                }

                $request->attributes->add(['permissionAttribute' => $permissionEx->permission]);
                return $next($request);
            }

            $core_group_id = CoreUser::find($user_id)->core_group_id;
            $permission = CorePermission::select('permission')->where('core_menu_id', $menu_id)->where('core_group_id', $core_group_id)->first();

            if (empty($permission->permission)) {
                return redirect('/no_permission');
            }

            $request->attributes->add(['permissionAttribute' => $permission->permission]);
            return $next($request);
        }

        return $next($request);
    }
}
