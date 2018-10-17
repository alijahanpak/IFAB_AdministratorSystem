<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestType;

class SeedRequestTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rType = new RequestType();
        $rType->rtSubject = 'خرید خدمات';
        $rType->rtType = 'BUY_SERVICES';
        $rType->rtPermission = 'BUY_SERVICES_REQUEST_REGISTER';
        $rType->save();

        $rType = new RequestType();
        $rType->rtSubject = 'خرید کالا';
        $rType->rtType = 'BUY_COMMODITY';
        $rType->rtPermission = 'c';
        $rType->save();

        $rType = new RequestType();
        $rType->rtSubject = 'تنخواه';
        $rType->rtType = 'FUND';
        $rType->rtPermission = 'REFUND_REQUEST_REGISTER';
        $rType->save();

        $rType = new RequestType();
        $rType->rtSubject = 'حقوق و مزایا';
        $rType->rtType = 'SALARY';
        $rType->rtPermission = 'SALARY_REQUEST_REGISTER';
        $rType->save();
    }
}
