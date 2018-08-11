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
        $this->call(SeedOfficeUniteTableSeeder::class);
        $this->call(SeedPublicSettingTableSeederTableSeeder::class);
        $this->call(SeederSubSystemTableSeederTableSeeder::class);
        $this->call(SeederSubSystemPartTableSeederTableSeeder::class);
        $this->call(SeedAmountUnitSeederTableSeeder::class);
        $this->call(SeederGroupTableSeederTableSeeder::class);
        $this->call(SeederRoleTableSeederTableSeeder::class);
        $this->call(SeederPermissionTableSeederTableSeeder::class);
        $this->call(SeederGroupPermissionTableSeederTableSeeder::class);
        $this->call(SeedAdminUsersTableSeeder::class);
        $this->call(SeederUserGroupTableSeederTableSeeder::class);
        $this->call(SeedAdminCountiesTableSeeder::class);
        $this->call(SeedAdminRegionsTableSeeder::class);
        $this->call(SeedAdminRuralDistrictsTableSeeder::class);
        $this->call(SeedAdminVillagesTableSeeder::class);
        $this->call(SeedAdminFiscalYearsTableSeederTableSeeder::class);
        $this->call(SeedSeasonTableSeederTableSeeder::class);
        $this->call(SeedSignatureTableSeeder::class);
        $this->call(SeedCategoryTableSeeder::class);
        $this->call(SeedRoleCategoryTableSeeder::class);

    }
}
