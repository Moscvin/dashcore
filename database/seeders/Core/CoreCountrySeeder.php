<?php

namespace Database\Seeders\Core;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Core\Addresses\CoreCountry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countriesJson = json_decode(Storage::disk('public')->get('/json/core_countries.json'), true);

        foreach ($countriesJson as $countryJson) {
            CoreCountry::create([
                'name' => $countryJson['name'],
                'short_name' => $countryJson['short_name']
            ]);
        }
    }
}
