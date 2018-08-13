<?php

namespace Modules\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\Commodity;

class SeedCommoditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $comm = new Commodity();
        $comm->cSubject = 'خودکار';
        $comm->save();

        $comm = new Commodity();
        $comm->cSubject = 'کاغذ';
        $comm->save();

        $comm = new Commodity();
        $comm->cSubject = 'چسب';
        $comm->save();

        $comm = new Commodity();
        $comm->cSubject = 'پوشه';
        $comm->save();

    }
}
