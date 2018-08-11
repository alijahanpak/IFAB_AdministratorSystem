<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\RequestStep;

class SeedRequestStepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rStep = new RequestStep();
        $rStep->rstRtId = 1;
        $rStep->rstCId = 1;
        $rStep->rstOrder = 1;
        $rStep->save();

        $rStep = new RequestStep();
        $rStep->rstRtId = 1;
        $rStep->rstCId = 2;
        $rStep->rstOrder = 2;
        $rStep->save();

        $rStep = new RequestStep();
        $rStep->rstRtId = 1;
        $rStep->rstCId = 4;
        $rStep->rstOrder = 3;
        $rStep->rstIsRequire = false;
        $rStep->save();

        $rStep = new RequestStep();
        $rStep->rstRtId = 1;
        $rStep->rstCId = 3;
        $rStep->rstOrder = 4;
        $rStep->save();

        /////////////////////////////
        $rStep = new RequestStep();
        $rStep->rstRtId = 2;
        $rStep->rstCId = 1;
        $rStep->rstOrder = 1;
        $rStep->save();

        $rStep = new RequestStep();
        $rStep->rstRtId = 2;
        $rStep->rstCId = 2;
        $rStep->rstOrder = 2;
        $rStep->save();

        $rStep = new RequestStep();
        $rStep->rstRtId = 2;
        $rStep->rstCId = 4;
        $rStep->rstOrder = 3;
        $rStep->rstIsRequire = false;
        $rStep->save();

        $rStep = new RequestStep();
        $rStep->rstRtId = 2;
        $rStep->rstCId = 3;
        $rStep->rstOrder = 4;
        $rStep->save();
    }
}
