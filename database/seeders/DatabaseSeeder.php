<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Core\CoreCitySeeder;
use Database\Seeders\Core\CoreMenuSeeder;
use Database\Seeders\Core\CoreUserSeeder;
use Database\Seeders\Core\CoreGroupSeeder;
use Database\Seeders\Core\CoreCountrySeeder;
use Database\Seeders\Core\CoreCustomerSeeder;
use Database\Seeders\Core\CoreProvinceSeeder;
use Database\Seeders\Core\CorePermissionSeeder;
use Database\Seeders\Core\CoreAdminOptionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoreGroupSeeder::class);
        $this->call(CoreUserSeeder::class);
        $this->call(CoreMenuSeeder::class);
        $this->call(CoreCustomerSeeder::class);
        $this->call(CoreAdminOptionSeeder::class);
        $this->call(CoreCountrySeeder::class);
        $this->call(CoreProvinceSeeder::class);
    }
}
