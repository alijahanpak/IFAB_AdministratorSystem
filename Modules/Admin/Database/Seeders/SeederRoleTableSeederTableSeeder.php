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
        $role->rOuId = 5;
        $role->rRole = 'BUDGET_ADMIN';
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارشناس بودجه';
        $role->rRole = 'BUDGET_EXPERT';
        $role->rOuId = 5;
        $role->save();

        $role = new Role;
        $role->rSubject = 'مسئول امور مالی';
        $role->rRole = 'FINANCIAL_DEPARTMENT_ADMIN';
        $role->rOuId = 6;
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارشناس مالی';
        $role->rRole = 'FINANCIAL_DEPARTMENT_EXPERT';
        $role->rOuId = 6;
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارشناس میراث فرهنگی';
        $role->rRole = 'CULTURAL_HERITAGE_EXPERT';
        $role->rOuId = 1;
        $role->save();

        $role = new Role;
        $role->rSubject = 'مدیرکل';
        $role->rRole = 'DIRECTOR_GENERAL';
        $role->rOuId = 7;
        $role->save();

        $role = new Role;
        $role->rSubject = 'مسئول واحد انفورماتیک';
        $role->rRole = 'INFORMATICS_ADMIN';
        $role->rOuId = 8;
        $role->save();

        $role = new Role;
        $role->rSubject = 'معاون میراث فرهنگی';
        $role->rRole = 'CULTURAL_HERITAGE_ASSISTANT';
        $role->rOuId = 1;
        $role->save();

        $role = new Role;
        $role->rSubject = 'معاون توسعه مدیریت و پشتیبانی';
        $role->rRole = 'MANAGEMENT_DEVELOPMENT_AND_SUPPORT_ASSISTANT';
        $role->rOuId = 9;
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارمند دبیرخانه';
        $role->rRole = 'SECRETARIAT_EMPLOYEE';
        $role->rOuId = 9;
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارمند انبار';
        $role->rRole = 'REPOSITORY_EMPLOYEE';
        $role->rOuId = 9;
        $role->save();

        $role = new Role;
        $role->rSubject = 'کارپرداز';
        $role->rRole = 'SUPPLIER';
        $role->rOuId = 10;
        $role->save();

        $role = new Role;
        $role->rSubject = 'مسئول واحد حقوقی';
        $role->rRole = 'LEGAL_ADMIN';
        $role->rOuId = 11;
        $role->save();
    }
}
