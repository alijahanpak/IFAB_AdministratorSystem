<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\AmountUnit;

class SeedAmountUnitSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $amountUnit = new AmountUnit;
        $amountUnit->auSubject = 'ریال';
        $amountUnit->auAmount = 1;
        $amountUnit->save();

        $amountUnit = new AmountUnit;
        $amountUnit->auSubject = 'هزار ریال';
        $amountUnit->auAmount = 1000;
        $amountUnit->save();

        $amountUnit = new AmountUnit;
        $amountUnit->auSubject = 'میلیون ریال';
        $amountUnit->auAmount = 1000000;
        $amountUnit->save();
    }
}
