<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\TinySeason;

class SeedTinySeasonsTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $tSeason = new TinySeason;
        $tSeason->tsUId = 1;
        $tSeason->tsSId = 1;
        $tSeason->tsPlanOrCost = 0;
        $tSeason->tsSubject = 'مطالعه برای احداث ساختمان و مستحدثات';
        $tSeason->tsDescription = 'برای تست';
        $tSeason->save();
    }
}
