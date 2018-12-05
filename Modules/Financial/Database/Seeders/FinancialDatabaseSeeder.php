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
        $this->call(SeedRequestTypeTableSeeder::class); //is need
        $this->call(SeederFactorStateTableSeeder::class); //is need
        $this->call(SeederRequestLevelTableSeeder::class); //is need
        $this->call(SeedRequestStateTableSeeder::class); //is need
        $this->call(SeederCheckStateTableSeeder::class); //is need
        $this->call(SeedCommoditiesTableSeeder::class); //is need
        //$this->call(SeedRequestTableSeeder::class);
        //$this->call(SeedRequestCommoditiesTableSeeder::class);
        $this->call(SeedRequestStepTableSeeder::class);
        $this->call(SeederPercentageIncreaseCategoryTableSeeder::class);
        $this->call(SeederPercentageIncreaseTableSeeder::class);
        $this->call(SeederPercentageDecreaseCategoryTableSeeder::class);
        $this->call(SeederPercentageDecreaseTableSeeder::class);
        $this->call(SeederDraftStateTableSeeder::class);
        $this->call(SeederCheckVerifierTableSeeder::class);
        $this->call(SeederPayRequestStatesTableSeeder::class);
        $this->call(SeederPayRequestStepsTableSeeder::class);
        $this->call(SeederDepositCategoryTableSeeder::class);
        $this->call(SeederDepositTableSeeder::class);
        $this->call(SeederRequestDepositStateTableSeeder::class);
    }
}
