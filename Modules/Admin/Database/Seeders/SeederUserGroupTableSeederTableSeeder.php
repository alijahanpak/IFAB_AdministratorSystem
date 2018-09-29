<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\UserGroup;

class SeederUserGroupTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 1;
        $userGroup->ugGId = 3;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 2;
        $userGroup->ugGId = 3;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 2;
        $userGroup->ugGId = 4;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 3;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 4;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 5;
        $userGroup->ugGId = 2;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 6;
        $userGroup->ugGId = 5;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 9;
        $userGroup->ugGId = 4;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 10;
        $userGroup->ugGId = 4;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 10;
        $userGroup->ugGId = 3;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 7;
        $userGroup->ugGId = 4;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 1;
        $userGroup->ugGId = 4;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 11;
        $userGroup->ugGId = 6;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 8;
        $userGroup->ugGId = 3;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 1;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 13;
        $userGroup->ugGId = 3;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 7;
        $userGroup->ugGId = 3;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 12;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 14;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 14;
        $userGroup->ugGId = 4;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 15;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 16;
        $userGroup->ugGId = 1;
        $userGroup->save();
    }
}
