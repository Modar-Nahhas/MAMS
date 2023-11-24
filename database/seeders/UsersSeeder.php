<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $adminUser */
        $adminUser = User::query()->firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@mams.com',
            'password' => Hash::make('12345678'),
        ]);
        $adminUser->assignRole(RolesEnum::Admin->value);
    }
}
