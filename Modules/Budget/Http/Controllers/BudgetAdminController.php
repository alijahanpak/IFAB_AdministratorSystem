<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\In;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\FiscalYear;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\Village;
use Modules\Budget\Entities\BudgetSeason;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;
use Modules\Budget\Entities\DeprivedArea;
use Modules\Budget\Entities\FyPermissionInBudget;

class BudgetAdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['only' => ['deprivedArea' , 'registerDeprivedArea' , 'updateDeprivedArea' , 'deleteDeprivedArea' , 'fiscalYear']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function deprivedArea()
    {
        $dAreas = DeprivedArea::all();
        return view('budget::pages.deprived_area.main' , ['pageTitle' => 'مناطق محروم' , 'dAreas' => $dAreas]);
    }

    public function registerDeprivedArea(Request $request)
    {

        $deprivedArea = new DeprivedArea;
        $deprivedArea->daUId = Auth::user()->id;
        $deprivedArea->daCoId = Input::get('daCounty');
        $deprivedArea->daReId = Input::get('daRegion');
        $deprivedArea->daRdId = Input::get('daRuralDistrict');
        $deprivedArea->daViId = Input::get('daVillage');
        $deprivedArea->daDescription = Input::get('daDescription');
        $deprivedArea->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف منطقه محروم ' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id));
        return Redirect::to(URL::previous());
    }

    public function fiscalYear()
    {
        return view('budget::pages.fiscal_year', ['pageTitle' => 'سال مالی']);
    }

    public function creditDistributionDef()
    {
        $creditDRs = CreditDistributionRow::all();
        $bSeasons = BudgetSeason::all();
        $creditDPs = CreditDistributionTitle::all();
        return view('budget::pages.credit_distribution_def.main' ,
            ['pageTitle' => 'تعاریف توزیع اعتبار' ,
                'creditDRs' => $creditDRs ,
                'bSeasons' => $bSeasons ,
                'creditDPs' => $creditDPs]);
    }

    public function registerCreditDistributionRow(Request $request)
    {
        $cdr = new CreditDistributionRow;
        $cdr->cdUId = Auth::user()->id;
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . Input::get('cdrSubject'));
        return Redirect::to(URL::previous());
    }

    public function subSeasons()
    {
        return view('budget::pages.sub_seasons', ['pageTitle' => 'ریز فصول']);
    }
    
    public function updateCreditDistributionRow(Request $request)
    {
        $old = CreditDistributionRow::find(Input::get('cdrId'));
        $cdr = CreditDistributionRow::find(Input::get('cdrId'));
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . Input::get('cdrSubject') . ')');
        return Redirect::to(URL::previous());
    }

    public function deleteCreditDistributionRow($cdId)
    {
        $cdr = CreditDistributionRow::find($cdId);
        try {
            $logTemp = $cdr->cdSubject;
            $cdr->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ردیف توزیع اعتبار ' . $logTemp);
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }

    public function fiscalYearActivation(Request $request)
    {
        FiscalYear::activation(Input::get('fyId'));
        SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find(Input::get('fyId'))->fyLabel  );
        return Redirect::to(URL::previous());
    }

    public function deleteDeprivedArea($dId)
    {
        $deprivedArea = DeprivedArea::find($dId);
        try {
            $logTemp = DeprivedArea::getDeprivedAreaLabel($dId);
            $deprivedArea->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف منطقه محروم ' . $logTemp);
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {

            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }

    public function updateDeprivedArea(Request $request)
    {
        $old = DeprivedArea::getDeprivedAreaLabel(Input::get('daId'));
        $deprivedArea = DeprivedArea::find(Input::get('daId'));
        $deprivedArea->daCoId = Input::get('daCounty');
        $deprivedArea->daReId = Input::get('daRegion');
        $deprivedArea->daRdId = Input::get('daRuralDistrict');
        $deprivedArea->daViId = Input::get('daVillage');
        $deprivedArea->daDescription = Input::get('daDescription');
        $deprivedArea->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در منطقه محروم (' . $old . ') به (' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id) . ')');
        return Redirect::to(URL::previous());
    }


    public function DAIsExist($coId , $reId = null , $rdId = null , $viId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (DeprivedArea::where('daCoId' , '=' , $coId)->where('daReId' , '=' , $reId)->where('daRdId' , '=' , $rdId)->where('daViId' , '=' , $viId)->exists())
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => true]);
            }
            else
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }
        }
    }

    public function DAIsExistForUpdate($daId , $coId , $reId = null , $rdId = null , $viId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (DeprivedArea::where('id' , '<>' , $daId)->where('daCoId' , '=' , $coId)->where('daReId' , '=' , $reId)->where('daRdId' , '=' , $rdId)->where('daViId' , '=' , $viId)->exists())
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => true]);
            }
            else
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }
        }
    }

    public function CDRIsExist($cdSubject , $cdId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($cdId == null)
            {
                if (CreditDistributionRow::where('cdSubject' , '=' , $cdSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
            else{
                if (CreditDistributionRow::where('id' , '<>' , $cdId)->where('cdSubject' , '=' , $cdSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
        }
    }

    function changeBudgetItemPermissionState($pbId , $state)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            $fyBudgetPermission = FyPermissionInBudget::find($pbId);
            $fyBudgetPermission->pbStatus = $state;
            $fyBudgetPermission->save();
            SystemLog::setBudgetSubSystemAdminLog('تغییر مجوز ' . $fyBudgetPermission->pbLabel . ' در سال مالی ' . FiscalYear::where('id' , '=' , $fyBudgetPermission->pbFyId)->value('fyLabel') . ' برای زیر سیستم بودجه.');
            return \Illuminate\Support\Facades\Response::json(['state' => true]);
        }
    }

    function checkSectionPermissionState($section , $fyId)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            switch ($section)
            {
                case 'budget':
                    $activeCount = FyPermissionInBudget::where('pbFyId' , '=' , $fyId)->where('pbStatus' , '=' , 1)->count();
                    if (FyPermissionInBudget::where('pbFyId' , '=' , $fyId)->count() == $activeCount)
                    {
                        return \Illuminate\Support\Facades\Response::json(['state' => true]);
                    }
                    else
                    {
                        return \Illuminate\Support\Facades\Response::json(['state' => false]);
                    }
            }
        }
    }

    function changeSectionPermissionState($section , $fyId , $state)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            switch ($section)
            {
                case 'budget':
                    FyPermissionInBudget::where('pbFyId' , '=' , $fyId)->update(['pbStatus' => $state]);
                    SystemLog::setBudgetSubSystemAdminLog('تغییر مجوز های سال مالی ' . FiscalYear::where('id' , '=' , $fyId)->value('fyLabel') . ' در زیر سیستم بودجه.');
                    return \Illuminate\Support\Facades\Response::json(['state' => true]);
            }
        }
    }

    public function registerBudgetSeason(Request $request)
    {
        $bs = new BudgetSeason;
        $bs->bsUId = Auth::user()->id;
        $bs->bsSubject = Input::get('bsSubject');
        $bs->bsDescription = Input::get('bsDescription');
        $bs->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف فصل بودجه ' . Input::get('bsSubject'));
        return Redirect::to(URL::previous() . '#budget_season_tab');
    }

    public function deleteBudgetSeason($bsId)
    {
        $bs = BudgetSeason::find($bsId);
        try {
            $logTemp = BudgetSeason::find($bsId);
            $bs->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف فصل بودجه ' . $logTemp->bsSubject);
            return Redirect::to(URL::previous() . '#budget_season_tab');
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous() . '#budget_season_tab')->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }

    public function BSIsExist($bsSubject , $bsId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($bsId == null)
            {
                if (BudgetSeason::where('bsSubject' , '=' , $bsSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
            else{
                if (BudgetSeason::where('id' , '<>' , $bsId)->where('bsSubject' , '=' , $bsSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
        }
    }

    public function updateBudgetSeason(Request $request)
    {
        $old = BudgetSeason::find(Input::get('bsId'));
        $bs = BudgetSeason::find(Input::get('bsId'));
        $bs->bsSubject = Input::get('bsSubject');
        $bs->bsDescription = Input::get('bsDescription');
        $bs->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در فصل بودجه (' . $old->bsSubject . ') به (' . $bs->bsSubject . ')');
        return Redirect::to(URL::previous() . '#budget_season_tab');
    }


    public function creditDistributionPlan()
    {
        return view('budget::pages.credit_distribution_plan', ['pageTitle' => 'ثبت طرحهای توزیع اعتبار']);
    }

    public function registerPlanTitle(Request $request)
    {
        $cdpt = new CreditDistributionTitle;
        $cdpt->cdtUId = Auth::user()->id;
        $cdpt->cdtBsId = Input::get('cdptSelectSeason');
        $cdpt->cdtIdNumber = Input::get('cdptIdNumber');
        $cdpt->cdtSubject = Input::get('cdptSubject');
        $cdpt->cdtDescription = Input::get('cdptDescription');
        $cdpt->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف طرح توزیع اعتبار با عنوان ' . Input::get('cdptSubject'));
        return Redirect::to(URL::previous() . '#plan_title_tab');
    }

    public function CDPTIsExist($cdptIdNumber , $cdptSubject , $cdptId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($cdptId == null)
            {
                if (CreditDistributionTitle::where('cdtIdNumber' , '=' , $cdptIdNumber)->orWhere('cdtSubject' , '=' , $cdptSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
            else{
                if (CreditDistributionTitle::where('id' , '<>' , $cdptId)->where('cdtIdNumber' , '=' , $cdptIdNumber)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
        }
    }

    public function updatePlanTitle(Request $request)
    {
        $old = CreditDistributionTitle::find(Input::get('cdptId'));
        $cdpt = CreditDistributionTitle::find(Input::get('cdptId'));
        $cdpt->cdtSubject = Input::get('cdptSubject');
        $cdpt->cdtIdNumber = Input::get('cdptIdNumber');
        $cdpt->cdtBsId = Input::get('cdptSelectSeason');
        $cdpt->cdtDescription = Input::get('cdptDescription');
        $cdpt->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان طرح توزیع اعتبار (' . $old->cdtSubject . ') به (' . $cdpt->cdtSubject . ')');
        return Redirect::to(URL::previous() . '#plan_title_tab');
    }

    public function deletePlanTitle($cdptId)
    {
        $cdpt = CreditDistributionTitle::find($cdptId);
        try {
            $logTemp = BudgetSeason::find($cdptId);
            $cdpt->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار ' . $logTemp->cdptSubject);
            return Redirect::to(URL::previous() . '#plan_title_tab');
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous() . '#budget_season_tab')->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }
}

