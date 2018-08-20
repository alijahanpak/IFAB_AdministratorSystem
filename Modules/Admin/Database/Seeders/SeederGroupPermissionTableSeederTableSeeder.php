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

        for ($i = 2 ; $i <= 76 ;$i++)
        {
            $gPermission = new GroupPermission;
            $gPermission->gpGId = 1;
            $gPermission->gpPId = $i;
            $gPermission->save();
        }

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new GroupPermission;
            $gPermission->gpGId = 2;
            $gPermission->gpPId = $i;
            $gPermission->save();
        }

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new GroupPermission;
            $gPermission->gpGId = 3;
            $gPermission->gpPId = $i;
            $gPermission->save();
        }

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new GroupPermission;
            $gPermission->gpGId = 4;
            $gPermission->gpPId = $i;
            $gPermission->save();
        }

        for ($i = 1 ; $i <= 77 ;$i++)
        {
            $gPermission = new GroupPermission;
            $gPermission->gpGId = 5;
            $gPermission->gpPId = $i;
            $gPermission->save();
        }


        $gPermission = new GroupPermission;
        $gPermission->gpGId = 6;
        $gPermission->gpPId = 76;
        $gPermission->save();

        $gPermission = new GroupPermission;
        $gPermission->gpGId = 6;
        $gPermission->gpPId = 78;
        $gPermission->save();

    }
}
