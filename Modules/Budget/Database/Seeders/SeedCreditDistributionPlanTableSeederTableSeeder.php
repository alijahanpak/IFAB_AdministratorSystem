<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;
use Modules\Budget\Entities\BudgetSeason;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;

class SeedCreditDistributionPlanTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $plans = CreditDistributionTitle::where('cdtCdtId' , '=' , null)->get();
        foreach ($plans as $plan)
        {
            foreach (CreditDistributionRow::where('cdPlanOrCost' , '=' , 0)->get() as $rows)
            {
                foreach (County::all() as $county)
                {
                    $cdp = new CreditDistributionPlan;
                    $cdp->cdpUId = 1;
                    $cdp->cdpCdtId = $plan->id;
                    $cdp->cdpCdrId = $rows->id;
                    $cdp->cdpFyId = 1;
                    $cdp->cdpCoId = $county->id;
                    $cdp->cdpCredit = rand(1000000000 , 150000000000);
                    $cdp->cdpDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
                    $cdp->save();
                }
            }
        }
    }
}
