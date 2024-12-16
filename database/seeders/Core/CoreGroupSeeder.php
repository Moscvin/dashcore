<?php

namespace Database\Seeders\Core;

use App\Models\Core\CoreGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreGroupsJson = json_decode(Storage::disk('public')->get('/json/core_groups.json'), true);

        foreach ($coreGroupsJson as $coreGroupJson) {
            CoreGroup::create([
                'name' => $coreGroupJson['name'],
            ]);
        }
    }
}
