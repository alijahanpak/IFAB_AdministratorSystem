<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\Deposit;

class SeederDepositTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $deposit = new Deposit();
        $deposit->dDcId = 1;
        $deposit->dDtId = 1;
        $deposit->dSubject = 'سپرده شماره ۱';
        $deposit->dPercent = 5;
        $deposit->save();

        $deposit = new Deposit();
        $deposit->dDcId = 1;
        $deposit->dDtId = 2;
        $deposit->dSubject = 'سپرده شماره ۲';
        $deposit->dPercent = 6;
        $deposit->save();

        $deposit = new Deposit();
        $deposit->dDcId = 2;
        $deposit->dDtId = 1;
        $deposit->dSubject = 'سپرده شماره ۳';
        $deposit->dPercent = 4;
        $deposit->save();

        $deposit = new Deposit();
        $deposit->dDcId = 2;
        $deposit->dDtId = 2;
        $deposit->dSubject = 'سپرده شماره ۴';
        $deposit->dPercent = 7;
        $deposit->save();
    }
}
