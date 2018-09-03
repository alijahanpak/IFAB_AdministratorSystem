<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestCommodity;

class SeedRequestCommoditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

/*        $reqComm = new RequestCommodity();
        $reqComm->rcRId = 1;
        $reqComm->rcCId = 1;
        $reqComm->rcCount = 10;
        $reqComm->rcCostEstimation = 6000;
        $reqComm->rcDescription = 'خودکار آبی';
        $reqComm->save();

        $reqComm = new RequestCommodity();
        $reqComm->rcRId = 1;
        $reqComm->rcCId = 2;
        $reqComm->rcCount = 13;
        $reqComm->rcCostEstimation = 6000;
        $reqComm->rcDescription = 'بسته کاغذ A4';
        $reqComm->save();*/
    }
}
