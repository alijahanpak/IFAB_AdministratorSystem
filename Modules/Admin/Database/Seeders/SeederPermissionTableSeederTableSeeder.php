<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Permission;

class SeederPermissionTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $permission = new Permission;
        $permission->pSsId = 2;
        $permission->pSubject = 'مدیریت زیر سیستم بودجه';
        $permission->pPermission = 'BUDGET_ADMIN';
    }
}
