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

        ///////////// budget dashboards ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 5;
        $permission->pSubject = 'مشاهده داشبورد';
        $permission->pPermission = 'BUDGET_DASHBOARD_DISPLAY';
        $permission->save();

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
        ////////////////////////////// budget cost allocation ////////////////////////////////
        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'مشاهده تخصیص های هزینه ای';
        $permission->pPermission = 'BUDGET_COST_ALLOCATION_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'ایجاد تخصیص هزینه ای';
        $permission->pPermission = 'BUDGET_COST_ALLOCATION_INSERT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'تغییر تخصیص هزینه ای';
        $permission->pPermission = 'BUDGET_COST_ALLOCATION_EDIT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 4;
        $permission->pSubject = 'حذف تخصیص هزینه ای';
        $permission->pPermission = 'BUDGET_COST_ALLOCATION_DELETE';
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

        ///////////// financial dashboards ///////////////////////
        $permission = new Permission;
        $permission->pSspId = 9;
        $permission->pSubject = 'مشاهده داشبورد مالی';
        $permission->pPermission = 'FINANCIAL_DASHBOARD_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 9;
        $permission->pSubject = 'مشاهده صف مالی';
        $permission->pPermission = 'FINANCIAL_QUEUE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 9;
        $permission->pSubject = 'تامین اعتبار تملک دارایی ها سرمایه ای';
        $permission->pPermission = 'FINANCIAL_CAPITAL_ASSETS_FINANCING';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 9;
        $permission->pSubject = 'تامین اعتبار هزینه ای';
        $permission->pPermission = 'FINANCIAL_COST_FINANCING';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 9;
        $permission->pSubject = 'تایید تامین اعتبار';
        $permission->pPermission = 'FINANCIAL_ACCEPT_FINANCING';
        $permission->save();

        ///////////////// secretariat ///////////////////////////
        $permission = new Permission;
        $permission->pSspId = 10;
        $permission->pSubject = 'مشاهده صف دبیرخانه';
        $permission->pPermission = 'SECRETARIAT_QUEUE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 10;
        $permission->pSubject = 'ثبت دبیرخانه درخواست';
        $permission->pPermission = 'SECRETARIAT_REGISTER_AND_NUMBERING';
        $permission->save();

        ///////////////// repository ///////////////////////////
        $permission = new Permission;
        $permission->pSspId = 11;
        $permission->pSubject = 'مشخص کردن کالاهای موجود در انبار';
        $permission->pPermission = 'DETERMINE_EXIST_COMMODITY_IN_REPOSITORY';
        $permission->save();

        ///////////////// supplier ///////////////////////////
        $permission = new Permission;
        $permission->pSspId = 12;
        $permission->pSubject = 'مشاهده صف کارپردازی';
        $permission->pPermission = 'SUPPLIER_QUEUE_DISPLAY';
        $permission->save();

        ///////////////// unit of contract ///////////////////////////
        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'مشاهده صف واحد عقد قرارداد';
        $permission->pPermission = 'UNIT_OF_CONTRACT_QUEUE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 9;
        $permission->pSubject = 'تایید پرداخت از تنخواه گردان';
        $permission->pPermission = 'FINANCIAL_ACCEPT_PAY_FROM_REFUND';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 7;
        $permission->pSubject = 'حذف موارد تامین اعتبار شده';
        $permission->pPermission = 'FINANCIAL_REMOVE_FINANCING_ITEM';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'ثبت اطلاعات قرارداد ها';
        $permission->pPermission = 'UNIT_OF_CONTRACT_ADD_NEW_CONTRACT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 12;
        $permission->pSubject = 'ثبت اطلاعات فاکتور ها';
        $permission->pPermission = 'SUPPLIER_ADD_NEW_FACTOR';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'حذف قرارداد';
        $permission->pPermission = 'UNIT_OF_CONTRACT_DELETE_CONTRACT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 12;
        $permission->pSubject = 'حذف فاکتور';
        $permission->pPermission = 'SUPPLIER_DELETE_FACTOR';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 12;
        $permission->pSubject = 'تایید نهایی اطلاعات فاکتور ها';
        $permission->pPermission = 'SUPPLIER_ACCEPT_FACTOR';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'تایید نهایی اطلاعات قرارداد ها';
        $permission->pPermission = 'UNIT_OF_CONTRACT_ACCEPT_CONTRACT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'حذف پیوست';
        $permission->pPermission = 'UNIT_OF_CONTRACT_DELETE_ATTACHMENT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'اضافه کردن پیوست جدید';
        $permission->pPermission = 'UNIT_OF_CONTRACT_ADD_NEW_ATTACHMENT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 15;
        $permission->pSubject = 'ایجاد حواله';
        $permission->pPermission = 'FINANCIAL_ADD_NEW_DRAFT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 13;
        $permission->pSubject = 'حذف حواله';
        $permission->pPermission = 'FINANCIAL_DELETE_DRAFT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 14;
        $permission->pSubject = 'مشاهده صف ذیحسابی';
        $permission->pPermission = 'ACCOUNTANT_QUEUE_DISPLAY';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 1;
        $permission->pSubject = 'امضاء حواله';
        $permission->pPermission = 'FINANCIAL_ACCEPT_DRAFT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 10;
        $permission->pSubject = 'ثبت دبیرخانه حواله';
        $permission->pPermission = 'FINANCIAL_REGISTER_AND_NUMBERING_DRAFT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 6;
        $permission->pSubject = 'تایید پیشنویس حواله';
        $permission->pPermission = 'FINANCIAL_ACCEPT_MINUTE_DRAFT';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 15;
        $permission->pSubject = 'تعیین کسورات قانونی و ایجاد چک';
        $permission->pPermission = 'FINANCIAL_DETERMINE_DECREASES_AND_MAKE_CHECKS';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 16;
        $permission->pSubject = 'پرینت چک';
        $permission->pPermission = 'FINANCIAL_PRINT_CHECK';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 16;
        $permission->pSubject = 'تحویل چک';
        $permission->pPermission = 'FINANCIAL_DELIVER_CHECK';
        $permission->save();

        $permission = new Permission;
        $permission->pSspId = 16;
        $permission->pSubject = 'مشاهده صف چک';
        $permission->pPermission = 'CHECK_LIST_DISPLAY';
        $permission->save();
    }
}
