<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsAllocation;

class SeederCapitalAssetsFoundTableSeederTableSeeder extends Seeder
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
            $alloc = new CapitalAssetsAllocation;
            $alloc->caaUId = 1;
            $alloc->caaFyId = 5;
            $alloc->caaFound = true;
            $alloc->caaLetterDate = '1396/10/' . rand(1 , 30);
            $alloc->caaDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';;
            $alloc->caaAmount = rand(1000000 , 100000000);
            $alloc->save();
        }
    }
}
