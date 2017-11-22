<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;

class SeedCapitalAssetsSeasonTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i=0 ; $i < 50 ; $i++)
        {
            $seasonTitle = new CapitalAssetsSeasonTitle;
            $seasonTitle->castUId = 1;
            $seasonTitle->castSId = rand(1,8);
            $seasonTitle->castSubject = 'عنوان فصل تملک داریی های سرمایه ای' . $i;
            $seasonTitle->castDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود. این گربه‌سان در حقیقت یک گربه وحشی با اندازه کوچک است که نام خود را از روی  محققی آلمانی گرفته‌ است که برای اولین بار در سال ۱۷۷۶ این پستانداران را یافت. نام این محقق «پیتر سایمون پالاس» (Peter Simon Pallas) بود. طول بدن گربه‌های پالاس بدون احتساب طول دم، ۴۶ تا ۶۵ سانتی‌متر است و خود دم به تنهایی طولی معادل ۲۱ تا ۳۱ سانتی‌متر دارد. ';
            $seasonTitle->save();
        }

    }
}
