<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CapitalAssetsTinySeason;

class SeedCapitalAssetsTinySeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i=1 ; $i <= 100 ; $i++) {
            $tSeason = new CapitalAssetsTinySeason;
            $tSeason->catsUId = 1;
            $tSeason->catsCastId = rand(1 , 50);
            $tSeason->catsSubject = 'ریز فصل تملک داریی های سرمایه ای' . $i;
            $tSeason->catsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود. این گربه‌سان در حقیقت یک گربه وحشی با اندازه کوچک است که نام خود را از روی  محققی آلمانی گرفته‌ است که برای اولین بار در سال ۱۷۷۶ این پستانداران را یافت. نام این محقق «پیتر سایمون پالاس» (Peter Simon Pallas) بود. طول بدن گربه‌های پالاس بدون احتساب طول دم، ۴۶ تا ۶۵ سانتی‌متر است و خود دم به تنهایی طولی معادل ۲۱ تا ۳۱ سانتی‌متر دارد.';
            $tSeason->save();
        }
    }
}
