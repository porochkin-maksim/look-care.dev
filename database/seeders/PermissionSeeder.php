<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['code' => 'admin', 'name' => 'Администрирование системы',],
        ];

        foreach($data as $d){
            $permission = Permission::whereCode($d['code'])->firstOrNew();
            $permission->fill($d)->save();
        }
    }
}
