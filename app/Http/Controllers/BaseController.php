<?php

namespace App\Http\Controllers;

use App\Models\Core\CoreMenu;
use App\Traits\Classes\Collection\MenuItem;
use App\Traits\Core\PermissionExceptionTrait;
use Auth;
use View;

class BaseController extends Controller
{
    use PermissionExceptionTrait;

    protected $user;
    protected $chars;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $appMenuItems = [];

            if(!Auth::guest()){
                $this->user = Auth::user();
                $menus = $this->menu_user();
                $appMenuItems = $this->getMenuItemsFormatted($menus);
                $this->chars = preg_split('//', \Request::get('permissionAttribute'), -1, PREG_SPLIT_NO_EMPTY);
            }
            
            View::share('appMenuItems', $appMenuItems);
            View::share('chars', $this->chars);
            return $next($request);
        });
    }

    private function getMenuItemsFormatted($menus)
    {
        return $menus->map(function($menu) {
            return new MenuItem(
                $menu->description,
                $menu->link,
                $menu->icon,
                $menu->show,
                $menu->id,
                $this->hasPermission($menu->id, $this->user),
                count($menu->children) ? $this->getMenuItemsFormatted($menu->children) : null
            );
        });
    }

    public function menu_user()
    {
        $menu = CoreMenu::tree();

        return count($menu) ? $menu : [];
    }
}
