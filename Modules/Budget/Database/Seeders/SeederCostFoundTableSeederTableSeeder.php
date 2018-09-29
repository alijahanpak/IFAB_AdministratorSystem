<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostAllocation;

class SeederCostFoundTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1 ; $i <= 4 ;$i++)
        {
            $alloc = new CostAllocation;
            $alloc->caUId = 1;
            $alloc->caFyId = 5;
            $alloc->caFound = true;
            $alloc->caLetterDate = '1396/09/' . rand(1 , 30);
            $alloc->caDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';;
            $alloc->caAmount = rand(100000000 , 10000000000);
            $alloc->save();
        }
    }
}
