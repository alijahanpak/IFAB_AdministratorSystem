<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\RolePermission;

class SeederRolePermissionTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new RolePermission;
            $rolePermission->rpRId = 1;
            $rolePermission->rpPId = $i;
            $rolePermission->save();
        }

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new RolePermission;
            $rolePermission->rpRId = 2;
            $rolePermission->rpPId = $i;
            $rolePermission->save();
        }

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new RolePermission;
            $rolePermission->rpRId = 3;
            $rolePermission->rpPId = $i;
            $rolePermission->save();
        }

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new RolePermission;
            $rolePermission->rpRId = 4;
            $rolePermission->rpPId = $i;
            $rolePermission->save();
        }
    }
}
