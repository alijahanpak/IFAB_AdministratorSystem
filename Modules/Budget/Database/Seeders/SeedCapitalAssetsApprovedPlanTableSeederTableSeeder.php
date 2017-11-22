<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;

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

/*        $cap = new CapitalAssetsApprovedPlan;
        $cap->capUId = 1;
        $cap->capCdtId = $request->cdtId;
        $cap->capFyId = 2;
        $cap->capLetterNumber = $request->idNumber;
        $cap->capLetterDate = $request->date;
        $cap->capExchangeIdNumber = $request->exIdNumber;
        $cap->capExchangeDate = $request->exDate;
        $cap->capProvinceOrNational = $request->pOrN;
        $cap->capDescription = $request->description;
        if (isset($request->capId))
            $cap->capCapId = $request->capId;
        $cap->save();*/
    }
}
