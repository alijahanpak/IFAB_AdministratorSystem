<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\GroupPermission;
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
        $userGroup->ugUId = 3;
        $userGroup->ugGId = 1;
        $userGroup->save();

        $userGroup = new UserGroup;
        $userGroup->ugUId = 4;
        $userGroup->ugGId = 2;
        $userGroup->save();

    }
}
