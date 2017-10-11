<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\HowToRun;

class SeedHowToRunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $howToRun = new HowToRun;
        $howToRun->htrSubject = 'امانی';
        $howToRun->save();

        $howToRun = new HowToRun;
        $howToRun->htrSubject = 'پیمانی';
        $howToRun->save();

        $howToRun = new HowToRun;
        $howToRun->htrSubject = 'امانی - پیمانی';
        $howToRun->save();
    }
}
