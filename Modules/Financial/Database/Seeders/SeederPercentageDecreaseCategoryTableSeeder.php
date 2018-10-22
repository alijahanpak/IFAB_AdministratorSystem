<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\PercentageDecreaseCategory;

class SeederPercentageDecreaseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $pdc = new PercentageDecreaseCategory();
        $pdc->pdcSubject = 'دسته بندی کسورات اول';
        $pdc->save();

        $pdc = new PercentageDecreaseCategory();
        $pdc->pdcSubject = 'دسته بندی کسورات دوم';
        $pdc->save();

        $pdc = new PercentageDecreaseCategory();
        $pdc->pdcSubject = 'دسته بندی کسورات سوم';
        $pdc->save();
    }
}
