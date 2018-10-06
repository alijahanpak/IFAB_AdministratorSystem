<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\SubSystemPart;

class SeederSubSystemPartTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        ////////////////// budget parts ///////////////////////////////////////////////
        $part = new SubSystemPart;
        $part->sspSsId = 2;
        $part->sspSubject = 'مدیریت';
        $part->sspPart = 'BUDGET_ADMIN';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 2;
        $part->sspSubject = 'توزیع اعتبار';
        $part->sspPart = 'BUDGET_CREDIT_DISTRIBUTION';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 2;
        $part->sspSubject = 'موافقتنامه';
        $part->sspPart = 'BUDGET_APPROVED';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 2;
        $part->sspSubject = 'تخصیص';
        $part->sspPart = 'BUDGET_ALLOCATION';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 2;
        $part->sspSubject = 'داشبورد';
        $part->sspPart = 'BUDGET_DASHBOARD';
        $part->save();

        /////////////////////// financial department parts ///////////////////////////
        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'مدیریت';
        $part->sspPart = 'FINANCIAL_DEPARTMENT_ADMIN';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'تامین اعتبار';
        $part->sspPart = 'FINANCIAL_DEPARTMENT_FOUNDING';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'سپرده';
        $part->sspPart = 'FINANCIAL_DEPARTMENT_DEPOSIT';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'داشبورد';
        $part->sspPart = 'FINANCIAL_DEPARTMENT_DASHBOARD';
        $part->save();

        /////////////////////// Management development parts /////////////////////
        $part = new SubSystemPart;
        $part->sspSsId = 4;
        $part->sspSubject = 'ثبت و شماره گذاری';
        $part->sspPart = 'SECRETARIAT_REGISTER_AND_NUMBERING';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 4;
        $part->sspSubject = 'انبار';
        $part->sspPart = 'REPOSITORY';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 4;
        $part->sspSubject = 'کاربردازی';
        $part->sspPart = 'SUPPLIER';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 4;
        $part->sspSubject = 'واحد عقد قرارداد';
        $part->sspPart = 'UNIT_OF_CONTRACT';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'ذیحسابی';
        $part->sspPart = 'ACCOUNTANT';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'واحد بررسی و تسجیل';
        $part->sspPart = 'CHECK_OUT';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 3;
        $part->sspSubject = 'واحد صدور چک';
        $part->sspPart = 'EXPORT_CHECK';
        $part->save();

        $part = new SubSystemPart;
        $part->sspSsId = 5;
        $part->sspSubject = 'عمومی';
        $part->sspPart = 'PUBLIC';
        $part->save();
    }
}
