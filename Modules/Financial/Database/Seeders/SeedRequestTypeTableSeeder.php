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
        $rType->save();

        $rType = new RequestType();
        $rType->rtSubject = 'خرید کالا';
        $rType->rtType = 'BUY_COMMODITY';
        $rType->save();

        $rType = new RequestType();
        $rType->rtSubject = 'تنخواه';
        $rType->rtType = 'FUND';
        $rType->save();
    }
}
