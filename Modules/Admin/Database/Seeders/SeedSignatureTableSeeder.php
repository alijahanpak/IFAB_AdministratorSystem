<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Signature;

class SeedSignatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $sig = new Signature();
        $sig->sUId = 1;
        $sig->sPath = asset('pic/signatures/test_signature.png');
        $sig->save();

        $sig = new Signature();
        $sig->sUId = 2;
        $sig->sPath = asset('pic/signatures/test_signature.png');
        $sig->save();

        $sig = new Signature();
        $sig->sUId = 3;
        $sig->sPath = asset('pic/signatures/test_signature.png');
        $sig->save();

        $sig = new Signature();
        $sig->sUId = 4;
        $sig->sPath = asset('pic/signatures/test_signature.png');
        $sig->save();

        $sig = new Signature();
        $sig->sUId = 5;
        $sig->sPath = asset('pic/signatures/test_signature.png');
        $sig->save();
    }
}
