<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsAllocation;

class SeedCapitalAssetsAllocationTableSeederTableSeeder extends Seeder
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
            $alloc = new CapitalAssetsAllocation;
            $alloc->caaUId = 1;
            $alloc->caaCcsId = CapCreditSource::inRandomOrder()->first()->id;
            $alloc->caaLetterNumber = '196/265-' . (4000 + $i);
            $alloc->caaLetterDate = '1396/10/' . rand(1 , 30);
            $alloc->caaDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $alloc->caaAmount = rand(1000000 , 100000000);
            $alloc->save();
        }
    }
}
