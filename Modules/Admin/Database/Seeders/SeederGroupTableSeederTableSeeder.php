<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Group;

class SeederGroupTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $group = new Group;
        $group->gSubject = 'کارشناسان مالی';
        $group->save();

        $group = new Group;
        $group->gSubject = 'کارشناسان بودجه';
        $group->save();

        $group = new Group;
        $group->gSubject = 'مسئولین واحدها';
        $group->save();

        $group = new Group;
        $group->gSubject = 'معاونین';
        $group->save();
    }
}
