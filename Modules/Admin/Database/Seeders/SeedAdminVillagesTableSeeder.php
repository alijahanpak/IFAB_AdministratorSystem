<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Village;

class SeedAdminVillagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $village = new Village;
        $village->viName = 'پیرسلمان';
        $village->viUId = User::first()->id;
        $village->viRdId = 1;
        $village->save();

        $village = new Village;
        $village->viName = 'فرسفج';
        $village->viUId = User::first()->id;
        $village->viRdId = 2;
        $village->save();

        $village = new Village;
        $village->viName = 'زنگنه علیا';
        $village->viUId = User::first()->id;
        $village->viRdId = 3;
        $village->save();

    }
}
