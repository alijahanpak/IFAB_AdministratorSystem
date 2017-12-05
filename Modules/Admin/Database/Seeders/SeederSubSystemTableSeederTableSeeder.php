<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\SubSystem;

class SeederSubSystemTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $subSystem = new SubSystem;
        $subSystem->ssSubject = 'مدیریت سیستم';
        $subSystem->save();

        $subSystem = new SubSystem;
        $subSystem->ssSubject = 'بودجه';
        $subSystem->save();

        $subSystem = new SubSystem;
        $subSystem->ssSubject = 'مالی';
        $subSystem->save();

        $subSystem = new SubSystem;
        $subSystem->ssSubject = 'کارگزینی';
        $subSystem->save();
    }
}
