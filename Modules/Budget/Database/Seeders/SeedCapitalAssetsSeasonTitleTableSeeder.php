<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;

class SeedCapitalAssetsSeasonTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $seasonTitle = new CapitalAssetsSeasonTitle;
        $seasonTitle->castUId = 1;
        $seasonTitle->castSId = 1;
        $seasonTitle->castSubject = 'جبران خدمت کارکنان';
        $seasonTitle->castDescription = 'برای تست';
        $seasonTitle->save();
    }
}
