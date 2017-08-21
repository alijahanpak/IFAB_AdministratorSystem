<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\FiscalYear;

class SeedAdminFiscalYearsTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $fiscalYear = new FiscalYear;
        $fiscalYear->fyUId = 1;
        $fiscalYear->fyLabel = '۱۳۹۶';
        $fiscalYear->fyDescription = 'سال مالی ۱۳۹۶ برای تست ایجاد می گردد';
        $fiscalYear->save();
    }
}
