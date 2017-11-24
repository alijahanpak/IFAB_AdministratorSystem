<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostAgreement;

class SeedCostAgreementTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1 ; $i <= 20 ; $i++)
        {
            $ca = new CostAgreement;
            $ca->caUId = 1;
            $ca->caFyId = 5;
            $ca->caProvinceOrNational = 0;
            $ca->caLetterNumber = '196/265-' . (4000 + $i);
            $ca->caLetterDate = '1396/10/' . rand(1 , 30);
            $ca->caExchangeIdNumber = '196/393-' . (4000 + $i);
            $ca->caExchangeDate = '1396/9/' . rand(1 , 30);
            $ca->caDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $ca->save();
        }

        for ($i = 1 ; $i <= 20 ; $i++)
        {
            $ca = new CostAgreement;
            $ca->caUId = 1;
            $ca->caFyId = 5;
            $ca->caProvinceOrNational = 1;
            $ca->caLetterNumber = '196/265-' . (2500 + $i);
            $ca->caLetterDate = '1396/10/' . rand(1 , 30);
            $ca->caDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $ca->save();
        }
    }
}
