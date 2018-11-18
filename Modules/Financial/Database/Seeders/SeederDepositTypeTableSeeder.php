<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DepositPercentageType;

class SeederDepositTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $dt = new DepositPercentageType();
        $dt->dptSubject = 'تسویه در تحویل موقت';
        $dt->dptType = 'SETTLEMENT_IN_TEMPORARY_DELIVERY';
        $dt->save();

        $dt = new DepositPercentageType();
        $dt->dptSubject = 'تسویه در تحویل قطعی';
        $dt->dptType = 'SETTLEMENT_IN_DEFINATIVE_DELIVERY';
        $dt->save();
    }
}
