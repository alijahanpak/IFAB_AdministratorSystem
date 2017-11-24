<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsCost;

class SeederCapitalAssetsCostTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1;$i <= 40 ;$i++)
        {
            $cost = new CapitalAssetsCost;
            $cost->cacUId = 1;
            $cost->cacSubject = 'سند هزینه شماره ' . $i;
            $cost->cacCaaId = CapitalAssetsAllocation::where('caaFound' , '=' , true)->inRandomOrder()->first()->id;
            $cost->cacAmount = rand(1000000 , 200000000);
            $cost->cacDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $cost->save();

        }
    }
}
