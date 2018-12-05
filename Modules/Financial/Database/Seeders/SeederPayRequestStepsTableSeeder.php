<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\PayRequestSteps;

class SeederPayRequestStepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $steps = new PayRequestSteps();
        $steps->prstCId = 1;
        $steps->prstOrder = 1;
        $steps->save();

        $steps = new PayRequestSteps();
        $steps->prstCId = 2;
        $steps->prstOrder = 2;
        $steps->save();

        $steps = new PayRequestSteps();
        $steps->prstCId = 4;
        $steps->prstOrder = 3;
        $steps->save();

        $steps = new PayRequestSteps();
        $steps->prstCId = 3;
        $steps->prstOrder = 4;
        $steps->save();
    }
}
