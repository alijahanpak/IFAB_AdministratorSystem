<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CostAllocation;

class SeedCostAllocationTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1 ; $i <= 100 ; $i++)
        {
            $alloc = new CostAllocation;
            $alloc->caUId = 1;
            $alloc->caCcsId = CaCreditSource::inRandomOrder()->first()->id;
            $alloc->caLetterNumber = '196/265-' . (4000 + $i);
            $alloc->caLetterDate = '1396/10/' . rand(1 , 30);
            $alloc->caDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $alloc->caAmount = rand(1000000000 , 10000000000);
            $alloc->save();
        }
    }
}
