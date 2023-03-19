<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                Permission::COL_NAME => 'Администрирование системы',
                Permission::COL_CODE => Permission::ADMIN,
            ],
        ];

        foreach($data as $d){
            $permission = Permission::whereCode($d['code'])->firstOrNew();
            $permission->fill($d)->save();
        }
    }
}
