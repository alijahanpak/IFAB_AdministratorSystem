<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CostAgreement;
use Modules\Budget\Entities\CostTinySeason;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;

class SeedCostCreditSourceTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i=1 ; $i < 50 ; $i++)
        {
            $caCs = new CaCreditSource;
            $caCs->ccsUId = 1;
            $caCs->ccsCaId = CostAgreement::where('caProvinceOrNational' , '=' , 0)->inRandomOrder()->first()->id;
            $caCs->ccsCdrId = CreditDistributionRow::where('cdPlanOrCost' , '=' , 0)->inRandomOrder()->first()->id;
            $caCs->ccsTsId = CostTinySeason::inRandomOrder()->first()->id;
            $caCs->ccsCdtId = CreditDistributionTitle::where('cdtCdtId' , '=' , null)->inRandomOrder()->first()->id;
            $caCs->ccsAmount = rand(10000000000 , 15000000000);
            $caCs->ccsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $caCs->save();
        }

        for ($i=1 ; $i < 50 ; $i++)
        {
            $caCs = new CaCreditSource;
            $caCs->ccsUId = 1;
            $caCs->ccsCaId = CostAgreement::where('caProvinceOrNational' , '=' , 1)->inRandomOrder()->first()->id;
            $caCs->ccsCdrId = CreditDistributionRow::where('cdPlanOrCost' , '=' , 1)->inRandomOrder()->first()->id;
            $caCs->ccsTsId = CostTinySeason::inRandomOrder()->first()->id;
            $caCs->ccsCdtId = CreditDistributionTitle::where('cdtCdtId' , '=' , null)->inRandomOrder()->first()->id;
            $caCs->ccsAmount = rand(10000000000 , 15000000000);
            $caCs->ccsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $caCs->save();
        }
    }
}
