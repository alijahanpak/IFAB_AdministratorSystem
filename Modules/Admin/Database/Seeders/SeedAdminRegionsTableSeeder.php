<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\Region;
use Modules\Admin\Entities\User;

class SeedAdminRegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $region = new Region;
        $region->reName = 'خزل';
        $region->reUId = User::first()->id;
        $region->reCoId = 5; //نهاوند
        $region->save();

        $region = new Region;
        $region->reName = 'شراء';
        $region->reUId = User::first()->id;
        $region->reCoId = 8; //نهاوند
        $region->save();

        $region = new Region;
        $region->reName = 'فامنین';
        $region->reUId = User::first()->id;
        $region->reCoId = 8; //نهاوند
        $region->save();

    }
}
