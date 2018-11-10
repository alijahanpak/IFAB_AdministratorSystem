<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestDepositState;

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

        $rdState = new RequestDepositState();
        $rdState->rdsSubject = 'بدهکار';
        $rdState->rdsState = 'OWE';
        $rdState->save();

        $rdState = new RequestDepositState();
        $rdState->rdsSubject = 'تسویه شده';
        $rdState->rdsState = 'CLEARED';
        $rdState->save();
    }
}
