<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Season;

class SeedSeasonTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $season = new Season;
        $season->sSubject = 'اول';
        $season->save();

        $season = new Season;
        $season->sSubject = 'دوم';
        $season->save();

        $season = new Season;
        $season->sSubject = 'سوم';
        $season->save();

        $season = new Season;
        $season->sSubject = 'چهارم';
        $season->save();

        $season = new Season;
        $season->sSubject = 'پنجم';
        $season->save();

        $season = new Season;
        $season->sSubject = 'ششم';
        $season->save();

        $season = new Season;
        $season->sSubject = 'هفتم';
        $season->save();

        $season = new Season;
        $season->sSubject = 'هشتم';
        $season->save();
    }
}
