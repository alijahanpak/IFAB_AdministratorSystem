<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostAllocation;
use Modules\Budget\Entities\ExpenseCosts;

class SeederExpenseCostTableSeederTableSeeder extends Seeder
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
            $cost = new ExpenseCosts;
            $cost->ecUId = 1;
            $cost->ecSubject = 'سند هزینه شماره ' . $i;
            $cost->ecCaId = CostAllocation::where('caFound' , '=' , true)->inRandomOrder()->first()->id;
            $cost->ecAmount = rand(10000 , 200000);
            $cost->ecDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
            $cost->save();

        }
    }
}
