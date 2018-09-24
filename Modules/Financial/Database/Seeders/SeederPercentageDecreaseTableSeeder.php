<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\PercentageDecrease;

class SeederPercentageDecreaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $percentageDecrease = new PercentageDecrease();
        $percentageDecrease->pdSubject = 'مالیات بر ارزش افزوده';
        $percentageDecrease->pdPercent = 0; //because 9 percent exist in increase table
        $percentageDecrease->pdPiId = 1;
        $percentageDecrease->save();

        $percentageDecrease = new PercentageDecrease();
        $percentageDecrease->pdSubject = 'بیمه تامین اجتماعی';
        $percentageDecrease->pdPercent = 2; //because 5 percent exist in increase table
        $percentageDecrease->pdPiId = 2;
        $percentageDecrease->save();

        $percentageDecrease = new PercentageDecrease();
        $percentageDecrease->pdSubject = 'کسورات شماره ۳';
        $percentageDecrease->pdPercent = 6;
        $percentageDecrease->save();
    }
}
