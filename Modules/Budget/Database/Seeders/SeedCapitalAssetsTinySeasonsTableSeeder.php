<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CapitalAssetsTinySeason;

class SeedCapitalAssetsTinySeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $tSeason = new CapitalAssetsTinySeason;
        $tSeason->catsUId = 1;
        $tSeason->catsCastId = 1;
        $tSeason->catsSubject = 'مطالعه برای احداث ساختمان و مستحدثات';
        $tSeason->catsDescription = 'برای تست';
        $tSeason->save();
    }
}
