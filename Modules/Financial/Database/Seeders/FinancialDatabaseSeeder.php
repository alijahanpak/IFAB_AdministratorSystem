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
        $this->call(SeedRequestStateTableSeeder::class);
        $this->call(SeedCommoditiesTableSeeder::class);
        $this->call(SeedRequestTableSeeder::class);
        $this->call(SeedRequestCommoditiesTableSeeder::class);
        $this->call(SeedRequestStepTableSeeder::class);
    }
}
