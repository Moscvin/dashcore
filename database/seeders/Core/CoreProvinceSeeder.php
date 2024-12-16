<?php

namespace Database\Seeders\Core;

use App\Models\Core\Addresses\CoreCity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Core\Addresses\CoreProvince;

class CoreProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreProvincesJson = json_decode(Storage::disk('public')->get('/json/core_provinces.json'), true);

        foreach($coreProvincesJson as $province){
            
            $coreProvince = CoreProvince::create([
                'short_name' => $province['short_name'],
                'name' => $province['name'],
                'core_region_id' => $province['id_region'] ?? null
            ]);

            foreach ($province['cities'] as $coreCityJson) {
                CoreCity::create([
                    'name' => $coreCityJson['name'],
                    'zip' => $coreCityJson['zip'],
                    'core_province_id' => $coreProvince->id
                ]);
            }
        }
    }
}
