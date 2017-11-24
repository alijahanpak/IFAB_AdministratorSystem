<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsProject;

class SeedCapitalAssetsApprovedProjectTableSeederTableSeeder extends Seeder
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
        $plans = CapitalAssetsApprovedPlan::where('capFyId' , '=' , 5)->with('creditDistributionTitle')->get();
        foreach ($plans as $plan)
        {
            $project = new CapitalAssetsProject;
            $project->cpUId = 1;
            $project->cpCapId = $plan->id;
            if ($plan->creditDistributionTitle->cdtCoId == null)
                $project->cpCoId = County::inRandomOrder()->first()->id;
            else
                $project->cpCoId = $plan->creditDistributionTitle->cdtCoId;
            $project->cpSubject = 'پروژه تملک داریی های سرمایه ای ' . $i;
            $project->cpCode = '0012' . $i;
            $project->cpStartYear = rand(1380 , 1390);
            $project->cpEndOfYear = rand(1397 , 1405);
            $project->cpPhysicalProgress = rand(30 , 100);
            $project->cpDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $project->save();
            $i++;
        }
    }
}
