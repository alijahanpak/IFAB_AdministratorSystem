<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Role;

class SeederRoleTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $role = new Role;
        $role->rSubject = 'مسئول بودجه';
        $role->rRole = 'BUDGET_ADMIN';
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارشناس بودجه';
        $role->rRole = 'BUDGET_EXPERT';
        $role->save();

        $role = new Role;
        $role->rSubject = 'مسئول امور مالی';
        $role->rRole = 'FINANCIAL_DEPARTMENT_ADMIN';
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارشناس مالی';
        $role->rRole = 'FINANCIAL_DEPARTMENT_EXPERT';
        $role->save();
    }
}