<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\PlanType;

class SeedPlanTypeTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $pt = new PlanType;
        $pt->ptSubject = 'انتفاعی';
        $pt->save();

        $pt = new PlanType;
        $pt->ptSubject = 'غیر انتفاعی';
        $pt->save();

    }
}
