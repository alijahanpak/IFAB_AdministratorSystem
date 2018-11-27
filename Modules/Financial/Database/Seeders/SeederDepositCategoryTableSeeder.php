<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DepositPercentageCategory;

class SeederDepositCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $dCategory = new DepositPercentageCategory();
        $dCategory->dpcSubject = 'کسور سپرده';
        $dCategory->save();
    }
}
