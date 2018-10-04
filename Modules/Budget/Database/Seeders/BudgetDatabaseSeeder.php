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

        $this->call(SeedFyPermissionTableSeeder::class); //is need
        $this->call(SeedCapitalAssetsSeasonTitleTableSeeder::class);
        $this->call(SeedCapitalAssetsTinySeasonsTableSeeder::class);
        $this->call(SeedHowToRunTableSeeder::class); //is need
        $this->call(SeedCostSeasonTitleTableSeeder::class);
        $this->call(SeedCostTinySeasonTableSeeder::class);
        $this->call(SeedBudgetSeasonTableSeederTableSeeder::class);
        $this->call(SeedCreditDistributionRowTableSeederTableSeeder::class); //is need
        $this->call(SeedCreditDistributionTitleTableSeederTableSeeder::class);
        $this->call(SeedCapitalAssetsApprovedPlanTableSeederTableSeeder::class);
        $this->call(SeedCapitalAssetsApprovedProjectTableSeederTableSeeder::class);
        $this->call(SeedCapitalAssetsCreditSourceTableSeederTableSeeder::class);
        $this->call(SeedCostAgreementTableSeederTableSeeder::class);
        $this->call(SeedCostCreditSourceTableSeederTableSeeder::class);
        $this->call(SeedCapitalAssetsAllocationTableSeederTableSeeder::class);
        $this->call(SeedCostAllocationTableSeederTableSeeder::class);
        $this->call(SeedCreditDistributionPlanTableSeederTableSeeder::class);
        $this->call(SeedProvincialBudgetProposalTableSeederTableSeeder::class);
        $this->call(SeederCapitalAssetsFoundTableSeederTableSeeder::class);
        $this->call(SeederCostFoundTableSeederTableSeeder::class);
        $this->call(SeederCapitalAssetsCostTableSeederTableSeeder::class);
        $this->call(SeederExpenseCostTableSeederTableSeeder::class);
    }
}
