<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\User;

class SeedAdminCountiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $county = new County;
        $county->coName = 'اسدآباد';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'همدان';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'ملایر';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'نهاوند';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'تویسرکان';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'رزن';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'کبودراهنگ';
        $county->coUId = User::first()->id;
        $county->save();

        $county = new County;
        $county->coName = 'فامنین';
        $county->coUId = User::first()->id;
        $county->save();


    }
}
