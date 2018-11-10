<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DepositType;

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

        $dt = new DepositType();
        $dt->dtSubject = 'تسویه در تحویل موقت';
        $dt->dtType = 'SETTLEMENT_IN_TEMPORARY_DELIVERY';
        $dt->save();

        $dt = new DepositType();
        $dt->dtSubject = 'تسویه در تحویل قطعی';
        $dt->dtType = 'SETTLEMENT_IN_DEFINATIVE_DELIVERY';
        $dt->save();
    }
}
