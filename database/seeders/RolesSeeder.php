<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RolesEnum::values();

        foreach ($roles as $role) {
            Role::query()->firstOrCreate([
                'name' => $role,
                'guard' => 'api'
            ]);
        }
    }
}
