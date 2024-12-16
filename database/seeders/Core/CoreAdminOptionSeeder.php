<?php

namespace Database\Seeders\Core;


use Illuminate\Database\Seeder;
use App\Models\Core\CoreAdminOption;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreAdminOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $coreAdminOptionsJson = json_decode(Storage::disk('public')->get('/json/core_admin_options.json'), true);

        foreach ($coreAdminOptionsJson as $coreAdminOptionJson) {
            CoreAdminOption::create([
                'description' => $coreAdminOptionJson['description'],
                'value' => $coreAdminOptionJson['value']
            ]);
        }
    }
}
