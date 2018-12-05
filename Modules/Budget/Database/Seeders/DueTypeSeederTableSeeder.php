<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\DueType;

class DueTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $dueType = new DueType();
        $dueType->dtType = 'ONE_YEAR';
        $dueType->dtSubject = 'یکساله';
        $dueType->save();

        $dueType = new DueType();
        $dueType->dtType = 'TWO_YEAR';
        $dueType->dtSubject = 'دو ساله';
        $dueType->save();

        $dueType = new DueType();
        $dueType->dtType = 'THREE_YEAR';
        $dueType->dtSubject = 'سه ساله';
        $dueType->save();

        $dueType = new DueType();
        $dueType->dtType = 'FOUR_YEAR';
        $dueType->dtSubject = 'چهار ساله';
        $dueType->save();

        $dueType = new DueType();
        $dueType->dtType = 'FIVE_YEAR';
        $dueType->dtSubject = 'پنج ساله';
        $dueType->save();

        $dueType = new DueType();
        $dueType->dtType = 'SIX_YEAR';
        $dueType->dtSubject = 'شش ساله';
        $dueType->save();

        $dueType = new DueType();
        $dueType->dtType = 'SEVEN_YEAR';
        $dueType->dtSubject = 'هفت ساله';
        $dueType->save();
    }
}
