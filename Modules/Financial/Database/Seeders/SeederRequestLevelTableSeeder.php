<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestLevel;
use Zend\Diactoros\Request;

class SeederRequestLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $requestLevel = new RequestLevel();
        $requestLevel->rlSubject = 'درخواست';
        $requestLevel->rlLevel = 'REQUEST';
        $requestLevel->save();

        $requestLevel = new RequestLevel();
        $requestLevel->rlSubject = 'تامین اعتبار';
        $requestLevel->rlLevel = 'FINANCIAL';
        $requestLevel->save();

        $requestLevel = new RequestLevel();
        $requestLevel->rlSubject = 'خرید و عقد قرارداد';
        $requestLevel->rlLevel = 'PURCHASE_AND_CONTRACT';
        $requestLevel->save();

        $requestLevel = new RequestLevel();
        $requestLevel->rlSubject = 'پرداخت';
        $requestLevel->rlLevel = 'PAYMENT';
        $requestLevel->save();

    }
}
