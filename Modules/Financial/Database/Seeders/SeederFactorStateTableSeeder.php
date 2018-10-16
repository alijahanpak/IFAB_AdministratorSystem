<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\FactorState;

class SeederFactorStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $state = new FactorState();
        $state->fsSubject = 'موقت';
        $state->fsState = 'TEMPORARY';
        $state->save();

        $state = new FactorState();
        $state->fsSubject = 'در انتظار بررسی';
        $state->fsState = 'PENDING_REVIEW';
        $state->save();

        $state = new FactorState();
        $state->fsSubject = 'تایید نشده';
        $state->fsState = 'NOT_ACCEPTED';
        $state->save();

        $state = new FactorState();
        $state->fsSubject = 'تایید شده';
        $state->fsState = 'ACCEPTED';
        $state->save();
    }
}
