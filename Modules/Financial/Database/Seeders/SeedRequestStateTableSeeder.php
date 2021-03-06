<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestState;

class SeedRequestStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rState = new RequestState();
        $rState->rsSubject = 'فعال';
        $rState->rsState = 'ACTIVE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'معلق';
        $rState->rsState = 'SUSPENDED';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'مسدود';
        $rState->rsState = 'BLOCKED';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در صف دبیرخانه';
        $rState->rsState = 'SECRETARIAT_QUEUE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'خاتمه یافته';
        $rState->rsState = 'CLOSED';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در صف امور مالی';
        $rState->rsState = 'FINANCIAL_QUEUE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در صف کارپردازی';
        $rState->rsState = 'SUPPLIER_QUEUE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در صف واحد عقد قرارداد';
        $rState->rsState = 'UNIT_OF_CONTRACT_QUEUE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در صف ذیحسابی';
        $rState->rsState = 'ACCOUNTANT_QUEUE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در انتظار درخواست پرداخت';
        $rState->rsState = 'WAITING_FOR_PAY_REQUEST';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در انتظار بررسی';
        $rState->rsState = 'WAITING_REVIEW';
        $rState->save();
    }
}
