<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\BudgetSeason;

class SeedBudgetSeasonTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $bs = new BudgetSeason;
        $bs->bsUId = 1;
        $bs->bsSubject = 'میراث فرهنگی';
        $bs->bsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود. این گربه‌سان در حقیقت یک گربه وحشی با اندازه کوچک است که نام خود را از روی  محققی آلمانی گرفته‌ است که برای اولین بار در سال ۱۷۷۶ این پستانداران را یافت. نام این محقق «پیتر سایمون پالاس» (Peter Simon Pallas) بود. طول بدن گربه‌های پالاس بدون احتساب طول دم، ۴۶ تا ۶۵ سانتی‌متر است و خود دم به تنهایی طولی معادل ۲۱ تا ۳۱ سانتی‌متر دارد. ';
        $bs->save();

        $bs = new BudgetSeason;
        $bs->bsUId = 1;
        $bs->bsSubject = 'صنایع دستی';
        $bs->bsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود. این گربه‌سان در حقیقت یک گربه وحشی با اندازه کوچک است که نام خود را از روی  محققی آلمانی گرفته‌ است که برای اولین بار در سال ۱۷۷۶ این پستانداران را یافت. نام این محقق «پیتر سایمون پالاس» (Peter Simon Pallas) بود. طول بدن گربه‌های پالاس بدون احتساب طول دم، ۴۶ تا ۶۵ سانتی‌متر است و خود دم به تنهایی طولی معادل ۲۱ تا ۳۱ سانتی‌متر دارد. ';
        $bs->save();

        $bs = new BudgetSeason;
        $bs->bsUId = 1;
        $bs->bsSubject = 'گردشگری';
        $bs->bsDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود. این گربه‌سان در حقیقت یک گربه وحشی با اندازه کوچک است که نام خود را از روی  محققی آلمانی گرفته‌ است که برای اولین بار در سال ۱۷۷۶ این پستانداران را یافت. نام این محقق «پیتر سایمون پالاس» (Peter Simon Pallas) بود. طول بدن گربه‌های پالاس بدون احتساب طول دم، ۴۶ تا ۶۵ سانتی‌متر است و خود دم به تنهایی طولی معادل ۲۱ تا ۳۱ سانتی‌متر دارد. ';
        $bs->save();
    }
}
