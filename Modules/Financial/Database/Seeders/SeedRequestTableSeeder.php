<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\_Request;

class SeedRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $req = new _Request();
        $req->rRsId = 1;
        $req->rRtId = 2;
        $req->rUId = 5;
        $req->rSubject = 'استفاده در دبیرخانه معاونت میراث';
        $req->rCostEstimation = 12000;
        $req->save();

    }
}
