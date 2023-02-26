<?php

namespace Database\Seeders;

use App\Enum\UserRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        foreach (UserRoles::cases() as $item) {
            Role::create(['name' => $item->value]);
        }
    }
}
