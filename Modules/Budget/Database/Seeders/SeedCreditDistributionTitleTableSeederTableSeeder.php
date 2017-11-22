<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\PublicSetting;
use Modules\Budget\Entities\CreditDistributionTitle;

class SeedCreditDistributionTitleTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 1 ;$i<=30 ; $i++)
        {
            $cdt = new CreditDistributionTitle;
            $cdt->cdtUId = 1;
            $cdt->cdtBsId = rand(1 , 3);
            $cdt->cdtIdNumber = '۱۷۰' . (4000 + $i);
            $cdt->cdtSubject = 'عنوان طرح / برنامه' . $i;
            $cdt->cdtDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود. این گربه‌سان در حقیقت یک گربه وحشی با اندازه کوچک است که نام خود را از روی  محققی آلمانی گرفته‌ است که برای اولین بار در سال ۱۷۷۶ این پستانداران را یافت. نام این محقق «پیتر سایمون پالاس» (Peter Simon Pallas) بود. طول بدن گربه‌های پالاس بدون احتساب طول دم، ۴۶ تا ۶۵ سانتی‌متر است و خود دم به تنهایی طولی معادل ۲۱ تا ۳۱ سانتی‌متر دارد.';
            $cdt->save();

            if ($i != rand(1 , 30))
            {
                $counties = County::all();
                $j = 1;
                foreach ($counties as $county){
                    $cdt_t = new CreditDistributionTitle;
                    $cdt_t->cdtUId = 1;
                    $cdt_t->cdtBsId = $cdt->cdtBsId;
                    $cdt_t->cdtCoId = $county->id;
                    $cdt_t->cdtCdtId = $cdt->id;
                    $cdt_t->cdtIdNumber = (170 + $j) . PublicSetting::getProvincePlanLebel() . $cdt->cdtIdNumber;
                    $cdt_t->cdtSubject = $cdt->cdtSubject;
                    $cdt_t->cdtDescription = 'گربه پالاس (Pallas cat)، پستانداری است که غالبا در مناطق مرکزی آسیا یافت می‌شود.';
                    $cdt_t->save();

                    $j++;
                }
            }
        }
    }
}
