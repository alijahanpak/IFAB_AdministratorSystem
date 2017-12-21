<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Permission;

class SeederPermissionTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        ///////////// budget fiscal year admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده سال های مالی';
        $permission->pPermission = 'BUDGET_ADMIN_FISCAL_YEARS_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر سطوح دسترسی در سال های مالی';
        $permission->pPermission = 'BUDGET_ADMIN_FISCAL_YEARS_EDIT_PERMISSIONS';
        $permission->save();

        ///////////// budget deprived area admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده مناطق محروم';
        $permission->pPermission = 'BUDGET_ADMIN_DEPRIVED_AREA_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'ایجاد منطقه محروم';
        $permission->pPermission = 'BUDGET_ADMIN_DEPRIVED_AREA_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر منطقه محروم';
        $permission->pPermission = 'BUDGET_ADMIN_DEPRIVED_AREA_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'حذف منطقه محروم';
        $permission->pPermission = 'BUDGET_ADMIN_DEPRIVED_AREA_DELETE';
        $permission->save();

        ///////////// budget BUDGET season admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده فصول بودجه';
        $permission->pPermission = 'BUDGET_ADMIN_BUDGET_SEASON_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'ایجاد فصل بودجه';
        $permission->pPermission = 'BUDGET_ADMIN_BUDGET_SEASON_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر فصل بودجه';
        $permission->pPermission = 'BUDGET_ADMIN_BUDGET_SEASON_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'حذف فصل بودجه';
        $permission->pPermission = 'BUDGET_ADMIN_BUDGET_SEASON_DELETE';
        $permission->save();

        ///////////// budget credit distribution row admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده ردیف های توزیع اعتبار';
        $permission->pPermission = 'BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'ایجاد ردیف های توزیع اعتبار';
        $permission->pPermission = 'BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر ردیف های توزیع اعتبار';
        $permission->pPermission = 'BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'حذف ردیف های توزیع اعتبار';
        $permission->pPermission = 'BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_DELETE';
        $permission->save();

        ///////////// budget plan or cost title admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده عناوین طرح / برنامه';
        $permission->pPermission = 'BUDGET_ADMIN_PLAN_RO_COST_TITLE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'ایجاد عناوین طرح / برنامه';
        $permission->pPermission = 'BUDGET_ADMIN_PLAN_RO_COST_TITLE_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر عناوین طرح / برنامه';
        $permission->pPermission = 'BUDGET_ADMIN_PLAN_RO_COST_TITLE_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'حذف عناوین طرح / برنامه';
        $permission->pPermission = 'BUDGET_ADMIN_PLAN_RO_COST_TITLE_DELETE';
        $permission->save();

        ///////////// budget season title admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده عنوان فصول هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_SEASON_TITLE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'ایجاد عنوان فصل هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_SEASON_TITLE_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر عنوان فصل هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_SEASON_TITLE_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'حذف عنوان فصل هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_SEASON_TITLE_DELETE';
        $permission->save();

        ///////////// budget tiny season admin ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'مشاهده ریز فصول هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_TINY_SEASON_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'ایجاد ریز فصل هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_TINY_SEASON_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'تغییر ریز فصل هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_TINY_SEASON_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'حذف ریز فصل هزینه';
        $permission->pPermission = 'BUDGET_ADMIN_TINY_SEASON_DELETE';
        $permission->save();

        ///////////// budget credit distribution plan ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'مشاهده طرح های توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PLAN_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'ایجاد طرح توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PLAN_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'تغییر طرح توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PLAN_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'حذف طرح توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PLAN_DELETE';
        $permission->save();

        ///////////// budget credit distribution proposal ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'مشاهده پیشنهاد های توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'ایجاد پیشنهاد توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'تغییر پیشنهاد توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 2;
        $permission->pSubject = 'حذف پیشنهاد توزیع اعتبار';
        $permission->pPermission = 'BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_DELETE';
        $permission->save();

        ///////////// budget capital assets approved plan ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'مشاهده موافقتنامه های تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'ایجاد موافقتنامه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'تغییر موافقتنامه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'حذف موافقتنامه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_DELETE';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'ایجاد اصلاحیه موافقتنامه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_AMENDMENT_INSERT';
        $permission->save();

        //////////////////////// budget capital assets approved project //////////////////////
        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'مشاهده پروژه های تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'ایجاد پروژه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'تغییر پروژه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'حذف پروژه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_DELETE';
        $permission->save();

        //////////////////////// budget capital assets approved project credit source //////////////////////
        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'مشاهده منابع توزیع اعتبار تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_CREDIT_SOURCE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'درج منابع توزیع اعتبار تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_CREDIT_SOURCE_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'تغییر منابع توزیع اعتبار تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_CREDIT_SOURCE_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'حذف منابع توزیع اعتبار تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_CREDIT_SOURCE_DELETE';
        $permission->save();
        ////////////////////////////// budget cost approved ////////////////////////////////
        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'مشاهده موافقتنامه های هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'ایجاد موافقتنامه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'تغییر موافقتنامه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'حذف موافقتنامه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_DELETE';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'ایجاد اصلاحیه موافقتنامه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_AMENDMENT_INSERT';
        $permission->save();

        ////////////////////////////// budget cost approved credit source ////////////////////////////////
        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'مشاهده منابع توزیع اعتبار هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_CREDIT_SOURCE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'ایجاد منابع توزیع اعتبار هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_CREDIT_SOURCE_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'تغییر منابع توزیع اعتبار هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_CREDIT_SOURCE_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 3;
        $permission->pSubject = 'حذف منابع توزیع اعتبار هزینه ای';
        $permission->pPermission = 'BUDGET_COST_APPROVED_PROG_CREDIT_SOURCE_DELETE';
        $permission->save();

        ////////////////////////////// budget capital assets allocation ////////////////////////////////
        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'مشاهده تخصیص های تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_ALLOCATION_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'ایجاد تخصیص های تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_ALLOCATION_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'تغییر تخصیص های تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'حذف تخصیص های تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE';
        $permission->save();

        ////////////////////////////// budget capital assets found allocation ////////////////////////////////
        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'مشاهده تنخواه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_FOUND_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'ایجاد تنخواه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_FOUND_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'تغییر تنخواه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_FOUND_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'حذف تنخواه تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_FOUND_DELETE';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'تبدیل تنخواه به تخصیص تملک داریی های سرمایه ای';
        $permission->pPermission = 'BUDGET_CAPITAL_ASSETS_FOUND_CONVERT_TO_ALLOCATION';
        $permission->save();

        ////////////////////////////// budget cost found allocation ////////////////////////////////
        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'مشاهده تنخواه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_FOUND_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'ایجاد تنخواه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_FOUND_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'تغییر تنخواه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_FOUND_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'حذف تنخواه هزینه ای';
        $permission->pPermission = 'BUDGET_COST_FOUND_DELETE';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'تبدیل تنخواه به تخصیص هزینه ای';
        $permission->pPermission = 'BUDGET_COST_FOUND_CONVERT_TO_ALLOCATION';
        $permission->save();

    }
}
