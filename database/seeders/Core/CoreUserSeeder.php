<?php

namespace Database\Seeders\Core;

use App\Models\Core\CoreGroup;
use App\Models\Core\CoreUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreUsersJson = json_decode(Storage::disk('public')->get('/json/core_users.json'), true);

        foreach ($coreUsersJson as $coreUserJson) {
            $adminGroup = CoreGroup::first();
            CoreUser::create([
                'core_group_id' => $adminGroup->id,
                'username' => $coreUserJson['username'],
                'email' => $coreUserJson['email'],
                'password' => $coreUserJson['password'],
                'name' => $coreUserJson['name'],
                'surname' => $coreUserJson['surname']
            ]);
        }
    }
}
