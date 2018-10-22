<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\PercentageIncreaseCategory;

class SeederPercentageIncreaseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $pdc = new PercentageIncreaseCategory();
        $pdc->picSubject = 'دسته بندی افزایش اول';
        $pdc->save();

        $pdc = new PercentageIncreaseCategory();
        $pdc->picSubject = 'دسته بندی افزایش دوم';
        $pdc->save();

        $pdc = new PercentageIncreaseCategory();
        $pdc->picSubject = 'دسته بندی افزایش سوم';
        $pdc->save();
    }
}
