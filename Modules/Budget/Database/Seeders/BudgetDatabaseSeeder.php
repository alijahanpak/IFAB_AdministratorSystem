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

        //$this->call(SeedCapitalAssetsSeasonTitleTableSeeder::class);
        //$this->call(SeedCapitalAssetsTinySeasonsTableSeeder::class);
        $this->call(SeedHowToRunTableSeeder::class); //is need
        $this->call(DueTypeSeederTableSeeder::class); //is need
        //$this->call(SeedCostSeasonTitleTableSeeder::class);
        //$this->call(SeedCostTinySeasonTableSeeder::class);
        $this->call(SeedBudgetSeasonTableSeederTableSeeder::class); //is need
        $this->call(SeedCreditDistributionRowTableSeederTableSeeder::class); //is need
        //$this->call(SeedCreditDistributionTitleTableSeederTableSeeder::class);
        //$this->call(SeedCapitalAssetsApprovedPlanTableSeederTableSeeder::class);
        //$this->call(SeedCapitalAssetsApprovedProjectTableSeederTableSeeder::class);
        //$this->call(SeedCapitalAssetsCreditSourceTableSeederTableSeeder::class);
        //$this->call(SeedCostAgreementTableSeederTableSeeder::class);
        //$this->call(SeedCostCreditSourceTableSeederTableSeeder::class);
        //$this->call(SeedCapitalAssetsAllocationTableSeederTableSeeder::class);
        //$this->call(SeedCostAllocationTableSeederTableSeeder::class);
        //$this->call(SeedCreditDistributionPlanTableSeederTableSeeder::class);
        //$this->call(SeedProvincialBudgetProposalTableSeederTableSeeder::class);
        //$this->call(SeederCapitalAssetsFoundTableSeederTableSeeder::class);
        //$this->call(SeederCostFoundTableSeederTableSeeder::class);
    }
}
