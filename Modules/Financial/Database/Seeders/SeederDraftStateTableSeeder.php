<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DraftState;

class SeederDraftStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $dState = new DraftState();
        $dState->dsSubject = 'پیشنویس';
        $dState->dsState = 'MINUTE';
        $dState->save();

        $dState = new DraftState();
        $dState->dsSubject = 'جدید';
        $dState->dsState = 'NEW';
        $dState->save();

        $dState = new DraftState();
        $dState->dsSubject = 'تایید شده';
        $dState->dsState = 'ACCEPTED';
        $dState->save();

        $dState = new DraftState();
        $dState->dsSubject = 'مسدود';
        $dState->dsState = 'BLOCKED';
        $dState->save();
    }
}
