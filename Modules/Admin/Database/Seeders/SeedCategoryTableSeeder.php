<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Category;

class SeedCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $cat = new Category();
        $cat->cSubject = 'کارشناس';
        $cat->cCategory = 'EXPERT';
        $cat->save();

        $cat = new Category();
        $cat->cSubject = 'معاون';
        $cat->cCategory = 'ASSISTANT';
        $cat->save();

        $cat = new Category();
        $cat->cSubject = 'مدیرکل';
        $cat->cCategory = 'DIRECTOR_GENERAL';
        $cat->save();

        $cat = new Category();
        $cat->cSubject = 'کارشناس واحد تخصصی';
        $cat->cCategory = 'SPECIALIZED_UNIT_EXPERT';
        $cat->save();

        $cat = new Category();
        $cat->cSubject = 'مسئول واحد';
        $cat->cCategory = 'UNIT_UNDERTAKING';
        $cat->save();

        $cat = new Category();
        $cat->cSubject = 'مسئول شهرستان';
        $cat->cCategory = 'COUNTY_UNDERTAKING';
        $cat->save();
    }
}
