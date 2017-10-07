<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BudgetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SeedFyPermissionTableSeeder::class);
        $this->call(SeedCapitalAssetsSeasonTitleTableSeeder::class);
        $this->call(SeedCapitalAssetsTinySeasonsTableSeeder::class);
        $this->call(SeedHowToRunTableSeeder::class);
        $this->call(SeedCostSeasonTitleTableSeeder::class);
        $this->call(SeedCostTinySeasonTableSeeder::class);
    }
}
