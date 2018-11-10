<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\DepositCategory;

class SeederDepositCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $dCategory = new DepositCategory();
        $dCategory->dcSubject = 'سپرده دسته بندی ۱';
        $dCategory->save();

        $dCategory = new DepositCategory();
        $dCategory->dcSubject = 'سپرده دسته بندی ۲';
        $dCategory->save();
    }
}
