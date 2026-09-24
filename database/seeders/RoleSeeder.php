<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = config('permissions.roles');
        $allPermissions = Permission::where('guard_name', 'web')->pluck('id');

        foreach ($roles as $roleName => $config) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $config['guard_name'] ?? 'web',
            ]);

            if (isset($config['permissions']) && $config['permissions'] === 'all') {
                $role->syncPermissions($allPermissions);
            } else {
                $permissionNames = $config['permissions'] ?? [];
                $permissions = Permission::where('guard_name', 'web')
                    ->whereIn('name', $permissionNames)
                    ->pluck('id');
                $role->syncPermissions($permissions);
            }

            $email = match ($roleName) {
                'superadmin' => 'superadmin@roarnext.com',
                'admin' => 'admin@roarnext.com',
                'manager' => 'manager@roarnext.com',
                'owner' => 'owner@roarnext.com',
                default => $roleName.'@roarnext.com',
            };

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => ucfirst($roleName),
                    'password' => Hash::make($roleName),
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles([$role->name]);
        }
    }
}
