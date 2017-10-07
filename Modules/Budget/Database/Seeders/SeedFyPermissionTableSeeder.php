<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\FyPermissionInBudget;

class SeedFyPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TOBudgetOffer';
        $fyPermissionInBudgetSubSystem->pbLabel = 'پیشنهاد بودجه تملک داریی های سرمایه ای استانی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TMBudgetOffer';
        $fyPermissionInBudgetSubSystem->pbLabel = 'پیشنهاد بودجه تملک داریی های سرمایه ای ملی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TOCreditDistributionScheme';
        $fyPermissionInBudgetSubSystem->pbLabel = 'طرح های توزیع اعتبار تملک داریی های سرمایه ای استانی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TOApprovedPlan';
        $fyPermissionInBudgetSubSystem->pbLabel = 'طرح های مصوب تملک داریی های سرمایه ای استانی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TMApprovedPlan';
        $fyPermissionInBudgetSubSystem->pbLabel = 'طرح های مصوب تملک داریی های سرمایه ای ملی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TOApprovedProject';
        $fyPermissionInBudgetSubSystem->pbLabel = 'پروژه های مصوب تملک داریی های سرمایه ای استانی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TMApprovedProject';
        $fyPermissionInBudgetSubSystem->pbLabel = 'پروژه های مصوب تملک داریی های سرمایه ای ملی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TOAllocation';
        $fyPermissionInBudgetSubSystem->pbLabel = 'تخصیص اعتبار تملک داریی های سرمایه ای استانی';
        $fyPermissionInBudgetSubSystem->save();

        $fyPermissionInBudgetSubSystem = new FyPermissionInBudget;
        $fyPermissionInBudgetSubSystem->pbFyId = 1;
        $fyPermissionInBudgetSubSystem->pbFieldName = 'TMAllocation';
        $fyPermissionInBudgetSubSystem->pbLabel = 'تخصیص اعتبار تملک داریی های سرمایه ای ملی';
        $fyPermissionInBudgetSubSystem->save();
    }
}
