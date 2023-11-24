<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /** @var Role $adminRole */
        $adminRole = Role::query()->firstOrCreate([
            'name' => RolesEnum::Admin->value,
            'guard_name' => 'api'
        ]);
        $adminRole->givePermissionTo(self::adminPermissions());

        /** @var Role $userRole */
        $userRole = Role::query()->firstOrCreate([
            'name' => RolesEnum::User->value,
            'guard_name' => 'api'
        ]);
        $userRole->givePermissionTo(self::userPermissions());

    }

    private static function adminPermissions(): array
    {
        return PermissionsEnum::values();
    }

    private static function userPermissions(): array
    {
        return [
            PermissionsEnum::ViewArticle->value,
            PermissionsEnum::StoreArticle->value,
            PermissionsEnum::UpdateArticle->value,
            PermissionsEnum::DestroyArticle->value,
        ];

    }
}
