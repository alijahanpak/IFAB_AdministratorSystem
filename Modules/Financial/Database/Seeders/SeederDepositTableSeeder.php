<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DepositPercentage;

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

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 1;
        $deposit->dpDptId = 1;
        $deposit->dpSubject = 'سپرده شماره ۱';
        $deposit->dpPercent = 5;
        $deposit->save();

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 1;
        $deposit->dpDptId = 2;
        $deposit->dpSubject = 'سپرده شماره ۲';
        $deposit->dpPercent = 6;
        $deposit->save();

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 2;
        $deposit->dpDptId = 1;
        $deposit->dpSubject = 'سپرده شماره ۳';
        $deposit->dpPercent = 4;
        $deposit->save();

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 2;
        $deposit->dpDptId = 2;
        $deposit->dpSubject = 'سپرده شماره ۴';
        $deposit->dpPercent = 7;
        $deposit->save();
    }
}
