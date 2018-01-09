<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\GroupPermission;

class SeederGroupPermissionTableSeederTableSeeder extends Seeder
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
            $rolePermission = new GroupPermission;
            $rolePermission->gpGId = 1;
            $rolePermission->gpPId = $i;
            $rolePermission->save();
        }

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new GroupPermission;
            $rolePermission->gpGId = 2;
            $rolePermission->gpPId = $i;
            $rolePermission->save();
        }

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new GroupPermission;
            $rolePermission->gpGId = 3;
            $rolePermission->gpPId = $i;
            $rolePermission->save();
        }

        for ($i = 1 ; $i <= 70 ;$i++)
        {
            $rolePermission = new GroupPermission;
            $rolePermission->gpGId = 4;
            $rolePermission->gpPId = $i;
            $rolePermission->save();
        }

    }
}
