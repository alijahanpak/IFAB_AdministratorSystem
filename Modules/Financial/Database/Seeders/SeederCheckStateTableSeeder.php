<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\CheckState;

class SeederCheckStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $checkState = new CheckState();
        $checkState->csSubject = 'در انتظار چاپ';
        $checkState->csState = 'WAITING_FOR_PRINT';
        $checkState->save();

        $checkState = new CheckState();
        $checkState->csSubject = 'در انتظار تحویل';
        $checkState->csState = 'WAITING_FOR_DELIVERY';
        $checkState->save();

        $checkState = new CheckState();
        $checkState->csSubject = 'تحویل داده شده';
        $checkState->csState = 'DELIVERED';
        $checkState->save();
    }
}
