<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SeedAdminUsersTableSeeder::class);
        $this->call(SeedAdminCountiesTableSeeder::class);
        $this->call(SeedAdminRegionsTableSeeder::class);
        $this->call(SeedAdminRuralDistrictsTableSeeder::class);
        $this->call(SeedAdminVillagesTableSeeder::class);
        $this->call(SeedAdminFiscalYearsTableSeederTableSeeder::class);
    }
}
