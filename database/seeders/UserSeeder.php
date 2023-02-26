<?php

namespace Database\Seeders;


use App\Enum\UserRoles;
use App\Models\User;
use Exception;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        DB::table('users')->truncate();

        User::withoutEvents(function () {
            $faker = Factory::create('fr');
            User::create([
                'email' => 'root@' . Str::snake(Str::lower(config('app.name', 'local')), '-') . '.com',
                'password' => '123456',
            ])
                ->assignRole(UserRoles::ROOT->name);

            //admin
            User::create([
                'email' => 'admin@' . Str::snake(Str::lower(config('app.name', 'local')), '-') . '.com',
                'password' => '123456',
            ])->assignRole(UserRoles::ADMINISTRATOR->name);
        });
    }
}
