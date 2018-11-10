<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FinancialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(SeedRequestTypeTableSeeder::class);
        $this->call(SeederFactorStateTableSeeder::class);
        $this->call(SeederRequestLevelTableSeeder::class);
        $this->call(SeedRequestStateTableSeeder::class);
        $this->call(SeederCheckStateTableSeeder::class);
        $this->call(SeedCommoditiesTableSeeder::class);
        $this->call(SeedRequestTableSeeder::class);
        $this->call(SeedRequestCommoditiesTableSeeder::class);
        $this->call(SeedRequestStepTableSeeder::class);
        $this->call(SeederPercentageIncreaseCategoryTableSeeder::class);
        $this->call(SeederPercentageIncreaseTableSeeder::class);
        $this->call(SeederPercentageDecreaseCategoryTableSeeder::class);
        $this->call(SeederPercentageDecreaseTableSeeder::class);
        $this->call(SeederDraftStateTableSeeder::class);
        $this->call(SeederCheckVerifierTableSeeder::class);
        $this->call(SeederPayRequestStatesTableSeeder::class);
        $this->call(SeederPayRequestStepsTableSeeder::class);

        $this->call(SeederDepositTypeTableSeeder::class);
        $this->call(SeederDepositCategoryTableSeeder::class);
        $this->call(SeederDepositTableSeeder::class);
        $this->call(SeederRequestDepositStateTableSeeder::class);
    }
}
