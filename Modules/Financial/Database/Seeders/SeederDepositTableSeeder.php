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
        $deposit->dpSubject = 'سپرده شماره ۱';
        $deposit->dpTemporaryPayPercent = 5;
        $deposit->dpDefinativePayPercent = 5;
        $deposit->dpFor = 'سپرده حس انجام کار ۱';
        $deposit->dpPayTo = 'خزانه';
        $deposit->save();

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 1;
        $deposit->dpSubject = 'سپرده شماره ۲';
        $deposit->dpTemporaryPayPercent = 5;
        $deposit->dpDefinativePayPercent = 5;
        $deposit->dpFor = 'سپرده حس انجام کار ۲';
        $deposit->dpPayTo = 'خزانه';
        $deposit->save();

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 2;
        $deposit->dpSubject = 'سپرده شماره ۳';
        $deposit->dpTemporaryPayPercent = 5;
        $deposit->dpDefinativePayPercent = 5;
        $deposit->dpFor = 'سپرده حس انجام کار ۳';
        $deposit->dpPayTo = 'خزانه';
        $deposit->save();

        $deposit = new DepositPercentage();
        $deposit->dpDpcId = 2;
        $deposit->dpSubject = 'سپرده شماره ۴';
        $deposit->dpTemporaryPayPercent = 5;
        $deposit->dpDefinativePayPercent = 5;
        $deposit->dpFor = 'سپرده حس انجام کار ۴';
        $deposit->dpPayTo = 'خزانه';
        $deposit->save();
    }
}
