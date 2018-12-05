<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\BudgetSeason;

class SeedBudgetSeasonTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $bs = new BudgetSeason;
        $bs->bsUId = 1;
        $bs->bsSubject = 'میراث فرهنگی';
        $bs->bsDescription = 'فصل میراث فرهنگی';
        $bs->save();

        $bs = new BudgetSeason;
        $bs->bsUId = 1;
        $bs->bsSubject = 'صنایع دستی';
        $bs->bsDescription = 'فصل صنایع دستی';
        $bs->save();

        $bs = new BudgetSeason;
        $bs->bsUId = 1;
        $bs->bsSubject = 'گردشگری';
        $bs->bsDescription = 'فصل گردشگری';
        $bs->save();
    }
}
