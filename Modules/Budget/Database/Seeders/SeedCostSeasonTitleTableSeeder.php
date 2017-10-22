<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostSeasonTitle;

class SeedCostSeasonTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $seasonTitle = new CostSeasonTitle;
        $seasonTitle->cstUId = 1;
        $seasonTitle->cstSId = 1;
        $seasonTitle->cstSubject = 'جبران خدمت کارکنان';
        $seasonTitle->cstDescription = 'برای تست';
        $seasonTitle->save();
    }
}
