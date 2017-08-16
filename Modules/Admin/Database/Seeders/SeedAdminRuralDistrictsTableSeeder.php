<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\RuralDistrict;
use Modules\Admin\Entities\User;

class SeedAdminRuralDistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ruralDistrict = new RuralDistrict;
        $ruralDistrict->rdName = 'کلیایی';
        $ruralDistrict->rdUId = User::first()->id;
        $ruralDistrict->rdReId = 1;
        $ruralDistrict->save();

        $ruralDistrict = new RuralDistrict;
        $ruralDistrict->rdName = 'چهاردولی';
        $ruralDistrict->rdUId = User::first()->id;
        $ruralDistrict->rdReId = 2;
        $ruralDistrict->save();

        $ruralDistrict = new RuralDistrict;
        $ruralDistrict->rdName = 'دیمکاران';
        $ruralDistrict->rdUId = User::first()->id;
        $ruralDistrict->rdReId = 3;
        $ruralDistrict->save();
    }
}
