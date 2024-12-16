<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Models\Core\CoreMenu;
use Illuminate\Http\Request;

class CoreMenuController extends BaseController
{
    public function index()
    {
        if (empty($this->chars)) return redirect('/no_permission');

        return view('core.menus.index');
    }

    public function ajax()
    {
        if (empty($this->chars)) return redirect('/no_permission');
        $coreMenuTree = CoreMenu::tree();

        return response()->json([
            'arr' => $coreMenuTree->toJson(),
        ], 200);
    }

    public function updateAll(Request $request)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $json = $request['menus'];
        $coreMenusAfterUpdate = $this->updateMenuChildren(json_decode($json));
        $coreMenus = CoreMenu::select('id')->pluck('id')->toArray();
        foreach ($coreMenus as $coreMenu) {
            if (!in_array($coreMenu, $coreMenusAfterUpdate) && !empty($coreMenu)) {
                $deletedCoreMenu = CoreMenu::where('id', $coreMenu)->first();
                $deletedCoreMenu->delete();
            }
        }
        return response()->json(['status' => 'Success'], 200);
    }

    public function updateMenuChildren($json, $parent = 0, $coreMenusAfterUpdate = null)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        if (!empty($json) && count($json) > 0) {
            foreach ($json as $key => $value) {
                $icon = (string) $value->icon;
                if (!empty($icon)) {
                    $icon = str_replace('fa fa-', '', $icon);
                }

                $data = [
                    'parent_id' => (int) $parent,
                    'list_order' => (int) $key,
                    'description' => (string) $value->description,
                    'link' => (string) $value->link,
                    'icon' => (string) $icon,
                    'show' => (string) $value->show,
                ];

                if (!empty($value->id)) {
                    $coreMenu = CoreMenu::where('id', $value->id)->first();
                    $coreMenu->update($data);
                    $currentCoreMenuId = $value->id;
                } else {
                    $newCoreMenu = CoreMenu::create($data);
                    $currentCoreMenuId = $newCoreMenu->id;
                }
                $coreMenusAfterUpdate[] = $currentCoreMenuId;

                if (!empty($value->children) && count($value->children) > 0) {
                    $coreMenusAfterUpdate = $this->updateMenuChildren($value->children, $currentCoreMenuId, $coreMenusAfterUpdate);
                }
            }
        }
        return $coreMenusAfterUpdate;
    }
}
