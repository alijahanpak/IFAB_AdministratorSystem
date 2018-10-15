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

        for ($i = 1 ; $i <= 76 ;$i++)
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

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 86;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 101;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 106;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 107;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 108;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 110;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 1;
        $gPermission->upPId = 114;
        $gPermission->save();

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 2;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 2;
        $gPermission->upPId = 111;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 2;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 2;
        $gPermission->upPId = 80;
        $gPermission->save();

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

        $gPermission = new UserPermission();
        $gPermission->upUId = 3;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 3;
        $gPermission->upPId = 117;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 3;
        $gPermission->upPId = 119;
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
        $gPermission->upPId = 112;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 4;
        $gPermission->upPId = 114;
        $gPermission->save();

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 5;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 5;
        $gPermission->upPId = 113;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 5;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 81;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 82;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 100;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 109;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 6;
        $gPermission->upPId = 114;
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
        $gPermission->upUId = 7;
        $gPermission->upPId = 99;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 7;
        $gPermission->upPId = 106;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 7;
        $gPermission->upPId = 107;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 7;
        $gPermission->upPId = 108;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 7;
        $gPermission->upPId = 110;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 7;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 8;
        $gPermission->upPId = 106;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 8;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 9;
        $gPermission->upPId = 106;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 9;
        $gPermission->upPId = 110;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 5;
        $gPermission->upPId = 113;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 9;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 10;
        $gPermission->upPId = 99;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 10;
        $gPermission->upPId = 106;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 10;
        $gPermission->upPId = 107;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 10;
        $gPermission->upPId = 108;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 10;
        $gPermission->upPId = 110;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 10;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 11;
        $gPermission->upPId = 83;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 11;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 84;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 89;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 91;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 92;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 115;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 12;
        $gPermission->upPId = 118;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 85;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 88;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 90;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 93;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 94;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 95;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 110;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 13;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 14;
        $gPermission->upPId = 98;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 14;
        $gPermission->upPId = 107;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 14;
        $gPermission->upPId = 110;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 14;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 15;
        $gPermission->upPId = 96;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 15;
        $gPermission->upPId = 97;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 15;
        $gPermission->upPId = 102;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 15;
        $gPermission->upPId = 107;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 15;
        $gPermission->upPId = 108;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 15;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 16;
        $gPermission->upPId = 103;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 16;
        $gPermission->upPId = 104;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 16;
        $gPermission->upPId = 105;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 16;
        $gPermission->upPId = 114;
        $gPermission->save();

        $gPermission = new UserPermission();
        $gPermission->upUId = 16;
        $gPermission->upPId = 120;
        $gPermission->save();

        for ($i = 1 ; $i <= 75 ;$i++)
        {
            $gPermission = new UserPermission();
            $gPermission->upUId = 17;
            $gPermission->upPId = $i;
            $gPermission->save();
        }

        $gPermission = new UserPermission();
        $gPermission->upUId = 17;
        $gPermission->upPId = 116;
        $gPermission->save();
    }
}
