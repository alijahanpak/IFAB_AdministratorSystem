<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\CheckVerifier;

class SeederCheckVerifierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $checkVerifier = new CheckVerifier();
        $checkVerifier->cvUId = 7;
        $checkVerifier->cvOrder = 1;
        $checkVerifier->save();

        $checkVerifier = new CheckVerifier();
        $checkVerifier->cvUId = 7;
        $checkVerifier->cvOrder = 2;
        $checkVerifier->save();
    }
}
