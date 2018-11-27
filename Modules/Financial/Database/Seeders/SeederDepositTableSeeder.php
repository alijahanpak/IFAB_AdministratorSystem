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
        $deposit->dpSubject = 'سپرده حسن انجام کار';
        $deposit->dpTemporaryPayPercent = 5;
        $deposit->dpDefinativePayPercent = 5;
        $deposit->dpPayTo = 'خزانه';
        $deposit->save();
    }
}
