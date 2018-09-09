<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\OfficeUnite;

class SeedOfficeUniteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'معاونت میراث فرهنگی';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'معاونت صنایع دستی';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'معاونت گردشگری';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'معاونت سرمایه گذاری';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'واحد بودجه';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'واحد مالی';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'حوزه مدیرکل';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'واحد انفورماتیک';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'معاونت توسعه مدیریت و پشتیبانی';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'واحد تدارکات';
        $officeUnite->save();

        $officeUnite = new OfficeUnite();
        $officeUnite->ouSubject = 'واحد حقوقی';
        $officeUnite->save();
    }
}
