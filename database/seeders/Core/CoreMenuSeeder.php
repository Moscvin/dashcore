<?php

namespace Database\Seeders\Core;

use App\Models\Core\CoreGroup;
use App\Models\Core\CoreMenu;
use App\Models\Core\CorePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreMenusJson = json_decode(Storage::disk('public')->get('/json/core_menus.json'), true);

        foreach ($coreMenusJson as $coreMenuJson) {
            $this->createItem($coreMenuJson, null);
        }
    }

    private function createItem($coreMenuJson, $parent)
    {
        $coreMenuParent = CoreMenu::create([
            'parent_id' => $parent->id ?? 0,
            'description' => $coreMenuJson['description'],
            'list_order' => $coreMenuJson['list_order'],
            'icon' => $coreMenuJson['icon'],
            'link' => $coreMenuJson['link'],
        ]);

        $adminGroup = CoreGroup::first();

        CorePermission::create([
            'core_menu_id' => $coreMenuParent->id,
            'core_group_id' => $adminGroup->id,
            'permission' => $coreMenuJson['permission']
        ]);

        if (count($coreMenuJson['children'])) {
            foreach ($coreMenuJson['children'] as $coreMenuJsonChild) {
                $this->createItem($coreMenuJsonChild, $coreMenuParent);
            }
        }
    }
}
