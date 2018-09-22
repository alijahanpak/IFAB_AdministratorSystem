<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\PercentageIncrease;

class SeederPercentageIncreaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $percentageIncrease = new PercentageIncrease();
        $percentageIncrease->piSubject = 'مالیات بر ارزش افزوده';
        $percentageIncrease->piPercent = 9;
        $percentageIncrease->save();
    }
}
