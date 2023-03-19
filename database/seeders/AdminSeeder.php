<?php

namespace Database\Seeders;

use App\Models\Permissions\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(string $name = User::ADMIN_NAME, string $password = User::ADMIN_PASSWORD): void
    {
        $admin = User::whereName($name)->firstOrNew();
        $admin->forceFill(['password' => $password ?: User::ADMIN_PASSWORD]);
        $admin->save();

        $roles = Role::select('id')
            ->get()
            ->map(function ($item) {
                return $item->id;
            })->toArray();

        $admin->roles()->detach();
        $admin->roles()->attach($roles);
    }
}
