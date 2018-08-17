<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestState;

class SeedRequestStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rState = new RequestState();
        $rState->rsSubject = 'فعال';
        $rState->rsState = 'ACTIVE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'معلق';
        $rState->rsState = 'SUSPENDED';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'مسدود';
        $rState->rsState = 'BLOCKED';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'در صف دبیرخانه';
        $rState->rsState = 'SECRETARIAT_QUEUE';
        $rState->save();

        $rState = new RequestState();
        $rState->rsSubject = 'خاتمه یافته';
        $rState->rsState = 'CLOSED';
        $rState->save();
    }
}
