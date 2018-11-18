<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DepositState;

class SeederRequestDepositStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rdState = new DepositState();
        $rdState->dsSubject = 'بدهکار';
        $rdState->dsState = 'OWE';
        $rdState->save();

        $rdState = new DepositState();
        $rdState->dsSubject = 'تسویه شده';
        $rdState->dsState = 'CLEARED';
        $rdState->save();
    }
}
