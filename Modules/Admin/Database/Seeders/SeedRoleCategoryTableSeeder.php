<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\RoleCategory;

class SeedRoleCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rCat = new RoleCategory();
        $rCat->rcRId = 1;
        $rCat->rcCId = 5;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 2;
        $rCat->rcCId = 1;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 3;
        $rCat->rcCId = 5;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 4;
        $rCat->rcCId = 1;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 5;
        $rCat->rcCId = 1;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 6;
        $rCat->rcCId = 3;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 7;
        $rCat->rcCId = 5;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 7;
        $rCat->rcCId = 4;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 8;
        $rCat->rcCId = 2;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 9;
        $rCat->rcCId = 2;
        $rCat->save();

        $rCat = new RoleCategory();
        $rCat->rcRId = 9;
        $rCat->rcCId = 3;
        $rCat->save();

    }
}
