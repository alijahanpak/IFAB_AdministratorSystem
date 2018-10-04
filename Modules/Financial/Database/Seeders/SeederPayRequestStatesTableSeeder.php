<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\PayRequestState;

class SeederPayRequestStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $state = new PayRequestState();
        $state->prsSubject = 'فعال';
        $state->prsState = 'ACTIVE';
        $state->save();

        $state = new PayRequestState();
        $state->prsSubject = 'مسدود';
        $state->prsState = 'BLOCKED';
        $state->save();
    }
}
