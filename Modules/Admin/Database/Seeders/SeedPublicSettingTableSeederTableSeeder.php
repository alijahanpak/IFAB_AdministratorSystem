<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\PublicSetting;

class SeedPublicSettingTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ps = new PublicSetting;
        $ps->psOrgName = 'اداره کل میراث فرهنگی، صنایع دستی و گردشگری استان همدان';
        $ps->psProvincePlanLabel = 'ه';
        $ps->save();
    }
}
