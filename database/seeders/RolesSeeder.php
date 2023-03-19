<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            Role::COL_NAME => 'Администратор',
            Role::COL_CODE => Role::ADMIN,
        ];

        $role = Role::whereCode(Role::ADMIN)->firstOrNew();
        $role->fill($data)->save();

        $permissions = Permission::select('id')
            ->get()
            ->map(function ($item) {
                return $item->id;
            })->toArray();

        $role->permissions()->detach();
        $role->permissions()->attach($permissions);
    }
}
