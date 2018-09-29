<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CapitalAssetsTinySeason;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\HowToRun;

class SeedCapitalAssetsCreditSourceTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        for ($i = 1; $i < 300 ; $i++)
        {
            $apCs = new CapCreditSource;
            $apCs->ccsUId = 2;
            $apCs->ccsCapId = CapitalAssetsProject::inRandomOrder()->first()->id;
            $apCs->ccsCdrId = CreditDistributionRow::where('cdPlanOrCost' , '=' , 0)->inRandomOrder()->first()->id;
            $apCs->ccsTsId = CapitalAssetsTinySeason::inRandomOrder()->first()->id;
            $apCs->ccsHtrId = HowToRun::inRandomOrder()->first()->id;
            $apCs->ccsAmount = rand(1000000000 , 150000000000);
            $apCs->ccsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $apCs->save();
        }
    }
}
