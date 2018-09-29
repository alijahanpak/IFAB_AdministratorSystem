<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\ProvincialBudgetProposal;

class SeedProvincialBudgetProposalTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $i = 1;
        foreach (CreditDistributionPlan::all() as $plan)
        {
            $pbp = new ProvincialBudgetProposal;
            $pbp->pbpUId = 1;
            $pbp->pbpCdpId = $plan->id;
            $pbp->pbpFyId = 5;
            $pbp->pbpAmount = rand(1000000000 , 200000000000);
            $pbp->pbpSubject = 'پروژه پیشنهادی ' . $i;
            $pbp->pbpCode = '0012' . $i;
            $pbp->pbpDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $pbp->save();
            $i++;
        }
    }
}
