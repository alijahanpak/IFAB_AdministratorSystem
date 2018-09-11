<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\UserPermission;

class SeederUserPermissionTableSeeder extends Seeder
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
            $gPermission = new UserPermission();
            $gPermission->upUId = 1;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 77;
        $gPermission->save();

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 2;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 3;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 3;
        $gPermission->upPId = 78;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 3;
        $gPermission->upPId = 86;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 3;
        $gPermission->upPId = 87;
        $gPermission->save();

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 4;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 4;
        $gPermission->upPId = 79;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 4;
        $gPermission->upPId = 86;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 4;
        $gPermission->upPId = 87;
        $gPermission->save();

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 5;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 81;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 82;
        $gPermission->save();
        /////////////////////////////////
        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 7;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 7;
        $gPermission->upPId = 80;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 11;
        $gPermission->upPId = 83;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 84;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 85;
        $gPermission->save();
    }
}
