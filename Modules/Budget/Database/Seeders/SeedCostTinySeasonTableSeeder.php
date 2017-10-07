<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostSeasonTitle;
use Modules\Budget\Entities\CostTinySeason;

class SeedCostTinySeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ctsSeason = new CostTinySeason;
        $ctsSeason->ctsUId = 1;
        $ctsSeason->ctsCstId = 1;
        $ctsSeason->ctsSubject = 'حقوق و دستمزد';
        $ctsSeason->ctsDescription = 'برای تست';
        $ctsSeason->save();
    }
}
