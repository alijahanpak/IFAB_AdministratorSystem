<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\FyPermissionInBudget;

class SeedFyPermissionTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->save();

    }
}
