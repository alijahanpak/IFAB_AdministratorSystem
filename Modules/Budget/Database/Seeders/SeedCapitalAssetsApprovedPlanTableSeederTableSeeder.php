<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;
use Modules\Budget\Entities\CreditDistributionTitle;

class SeedCapitalAssetsApprovedPlanTableSeederTableSeeder extends Seeder
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
        foreach (CreditDistributionTitle::where('cdtCdtId' , '=' , null)->get() as $title)
        {
            $cap = new CapitalAssetsApprovedPlan;
            $cap->capUId = 1;
            $cap->capCdtId = $title->id;
            $cap->capFyId = 2;
            $cap->capLetterNumber = '196/265-' . (4000 + $i);
            $cap->capLetterDate = '1396/10/' . rand(1 , 30);
            $cap->capExchangeIdNumber = '196/393-' . (4000 + $i);
            $cap->capExchangeDate = '1396/9/' . rand(1 , 30);
            $cap->capProvinceOrNational = 1;
            $cap->capDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $cap->save();
            $i++;
        }

        $i = 1;
        foreach (CreditDistributionTitle::where('cdtCdtId' , '<>' , null)->get() as $title)
        {
            $cap = new CapitalAssetsApprovedPlan;
            $cap->capUId = 1;
            $cap->capCdtId = $title->id;
            $cap->capFyId = 2;
            $cap->capLetterNumber = '296/265-' . (5100 + $i);
            $cap->capLetterDate = '1396/10/' . rand(1 , 30);
            $cap->capExchangeIdNumber = '296/393-' . (3200 + $i);
            $cap->capExchangeDate = '1396/9/' . rand(1 , 30);
            $cap->capProvinceOrNational = 0;
            $cap->capDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $cap->save();
            $i++;
        }
    }
}
