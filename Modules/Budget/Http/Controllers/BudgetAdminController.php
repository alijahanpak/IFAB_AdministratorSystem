<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\In;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\FiscalYear;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\Season;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\Village;
use Modules\Budget\Entities\BudgetSeason;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;
use Modules\Budget\Entities\DeprivedArea;
use Modules\Budget\Entities\FyPermissionInBudget;
use Modules\Budget\Entities\HowToRun;
use Modules\Budget\Entities\TinySeason;
use Ramsey\Uuid\Uuid;

class BudgetAdminController extends Controller
{
    public function __construct() {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function deprivedArea()
    {
        $dAreas = DeprivedArea::all();
        return view('budget::pages.deprived_area.main' , ['pageTitle' => 'مناطق محروم' ,
            'dAreas' => $dAreas,
            'requireJsFile' => 'deprived_area']);
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
        return view('budget::pages.fiscal_year', ['pageTitle' => 'سال مالی',
            'requireJsFile' => 'fiscal_year']);
    }

    public function creditDistributionDef()
    {
        $creditDRs = CreditDistributionRow::all();
        $bSeasons = BudgetSeason::all();
        $creditDPs = CreditDistributionTitle::where('cdtCoId' , '=' , null)->where('cdtCdtId' , '=' , null)->get();
        return view('budget::pages.credit_distribution_def.main' ,
            ['pageTitle' => 'تعاریف توزیع اعتبار' ,
                'creditDRs' => $creditDRs ,
                'bSeasons' => $bSeasons ,
                'creditDPs' => $creditDPs,
                'requireJsFile' => 'credit_distributed_def']);
    }

    public function registerCreditDistributionRow(Request $request)
    {
        $cdr = new CreditDistributionRow;
        $cdr->cdUId = Auth::user()->id;
        $cdr->cdPlanOrCost = 0;
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . Input::get('cdrSubject'));
        return Redirect::to(URL::previous());
    }

    public function subSeasons()
    {
        $subSeasons = TinySeason::select(['tsSId'])->groupBy(['tsSId'])->get();
        $seasons = Season::all();
        return view('budget::pages.sub_seasons.main', ['subSeasons' => $subSeasons,
            'seasons' => $seasons ,
            'requireJsFile' => 'tiny_season',
            'pageTitle' => 'ریز فصول']);
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

/*    public function fiscalYearActivation(Request $request)
    {
        FiscalYear::activation(Input::get('fyId'));
        SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find(Input::get('fyId'))->fyLabel  );
        return Redirect::to(URL::previous());
    }*/

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

/*    function changeBudgetItemPermissionState($pbId , $state)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            $fyBudgetPermission = FyPermissionInBudget::find($pbId);
            $fyBudgetPermission->pbStatus = $state;
            $fyBudgetPermission->save();
            SystemLog::setBudgetSubSystemAdminLog('تغییر مجوز ' . $fyBudgetPermission->pbLabel . ' در سال مالی ' . FiscalYear::where('id' , '=' , $fyBudgetPermission->pbFyId)->value('fyLabel') . ' برای زیر سیستم بودجه.');
            return \Illuminate\Support\Facades\Response::json(['state' => true]);
        }
    }*/

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

/*    function changeSectionPermissionState($section , $fyId , $state)
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
    }*/

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

    public function registerPlanTitle(Request $request)
    {
        $cdpt = new CreditDistributionTitle;
        $cdpt->cdtUId = Auth::user()->id;
        $cdpt->cdtBsId = Input::get('cdptSelectSeason');
        $cdpt->cdtIdNumber = Input::get('cdptIdNumber');
        $cdpt->cdtSubject = Input::get('cdptSubject');
        $cdpt->cdtDescription = Input::get('cdptDescription');
        $cdpt->save();

        $counties = County::all();
        foreach ($counties as $county)
        {
            if (Input::get('cdptCounty' . $county->id) != '')
            {
                $cdpt_co = new CreditDistributionTitle;
                $cdpt_co->cdtUId = Auth::user()->id;
                $cdpt_co->cdtBsId = Input::get('cdptSelectSeason');
                $cdpt_co->cdtIdNumber = Input::get('cdptCounty' . $county->id) . PublicSetting::getProvincePlanLebel() . Input::get('cdptIdNumber');
                $cdpt_co->cdtSubject = Input::get('cdptSubject');
                $cdpt_co->cdtDescription = Input::get('cdptCountyDesc' . $county->id);
                $cdpt_co->cdtCoId = $county->id;
                $cdpt_co->cdtCdtId = $cdpt->id;
                $cdpt_co->save();
                SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان طرح توزیع اعتبار در سطح شهرستان ' . $county->coName);
            }
        }

        SystemLog::setBudgetSubSystemAdminLog('تعریف طرح توزیع اعتبار با عنوان ' . Input::get('cdptSubject'));
        return Redirect::to(URL::previous() . '#plan_title_tab');
    }

    public function CDPTIsExist($cdptIdNumber , $cdptSubject , $cdptId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($cdptId == null)
            {
                if (CreditDistributionTitle::where('cdtIdNumber' , '=' , $cdptIdNumber)->exists())
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
        $cdpt->cdtUId = Auth::user()->id;
        $cdpt->cdtBsId = Input::get('cdptSelectSeason');
        $cdpt->cdtIdNumber = Input::get('cdptIdNumber');
        $cdpt->cdtSubject = Input::get('cdptSubject');
        $cdpt->cdtDescription = Input::get('cdptDescription');
        $cdpt->save();

        $counties = County::all();
        foreach ($counties as $county)
        {
            $cdtP = CreditDistributionTitle::where('cdtCdtId' , $cdpt->id);
            if (Input::get('cdptCounty' . $county->id) != '')
            {
                if ($cdtP->where('cdtIdNumber' , '=' , Input::get('cdptCounty' . $county->id) . PublicSetting::getProvincePlanLebel() . Input::get('cdptIdNumber'))->exists())
                {
                    $cdtP->where('cdtIdNumber' , '=' , Input::get('cdptCounty' . $county->id) . PublicSetting::getProvincePlanLebel() . Input::get('cdptIdNumber'))->update(['cdtIdNumber' => Uuid::uuid4() . Auth::user()->id]);
                }
                CreditDistributionTitle::updateOrCreate(['cdtCdtId' => Input::get('cdptId') , 'cdtCoId' => $county->id] , ['cdtUId' => Auth::user()->id,
                    'cdtBsId' => Input::get('cdptSelectSeason'),
                    'cdtIdNumber' => Input::get('cdptCounty' . $county->id) . PublicSetting::getProvincePlanLebel() . Input::get('cdptIdNumber'),
                    'cdtSubject' => Input::get('cdptSubject'),
                    'cdtDescription' => Input::get('cdptCountyDesc' . $county->id),
                    'cdtCoId' => $county->id,
                    'cdtCdtId' => $cdpt->id]);
                SystemLog::setBudgetSubSystemAdminLog('تغییر عنوان طرح توزیع اعتبار در سطح شهرستان ' . $county->coName);
            }
            else if($cdtP->where('cdtCoId' , $county->id)->exists()){
                try {
                    $cdtP->where('cdtCoId' , $county->id)->delete();
                    SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار ' . $county->coName);
                }
                catch (\Illuminate\Database\QueryException $e) {
                }
            }
        }
        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان طرح توزیع اعتبار (' . $old->cdtSubject . ') به (' . $cdpt->cdtSubject . ')');
        return Redirect::to(URL::previous() . '#plan_title_tab');
    }

    public function deletePlanTitle($cdptId)
    {
        try {
            $logTemp = CreditDistributionTitle::find($cdptId);
            CreditDistributionTitle::where('cdtCdtId' , '=' , $cdptId)->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار در سطح شهرستان با عنوان ' . $logTemp->cdptSubject);

            $cdpt = CreditDistributionTitle::find($cdptId);
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

    public function registerSubSeason(Request $request)
    {
        $ts = new TinySeason;
        $ts->tsUId = Auth::user()->id;
        $ts->tsSId = Input::get('sId');
        $ts->tsPlanOrCost = 0; //capital assets
        $ts->tsSubject = Input::get('tsSubject');
        $ts->tsDescription = Input::get('tsDescription');
        $ts->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل ' . Input::get('tsSubject') . ' در فصل ' . Season::find(Input::get('sId'))->sSubject);
        return Redirect::to(URL::previous());
    }

    public function deleteSubSeason($tsId)
    {
        $ts = TinySeason::find($tsId);
        try {
            $logTemp = TinySeason::find($tsId);
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $logTemp->tsSubject);
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }

    public function SSIsExist($sId , $tsSubject , $tsId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($tsId == null)
            {
                if (TinySeason::where('tsSId' , '=' , $sId)->Where('tsSubject' , '=' , $tsSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
            else{
                if (TinySeason::where('id' , '<>' , $tsId)->where('tsSId' , '=' , $sId)->where('tsSubject' , '=' , $tsSubject)->exists())
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

    public function updateSubSeason(Request $request)
    {
        $old = TinySeason::find(Input::get('tsId'));
        $ts = TinySeason::find(Input::get('tsId'));
        $ts->tsSId = Input::get('sId');
        $ts->tsSubject = Input::get('tsSubject');
        $ts->tsDescription = Input::get('tsDescription');
        $ts->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->tsSubject . ') به (' . $ts->tsSubject . ')');
        return Redirect::to(URL::previous() . '#plan_title_tab');
    }

    ///////////////////////////////////////////////////////////////

    public function registerTinySeason(Request $request)
    {
        if (TinySeason::where('tsSId' , '=' , $request->tsSId)
            ->where('tsPlanOrCost' , '=' , $request->planOrCost)
            ->Where('tsSubject' , '=' , $request->tsSubject)
            ->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $ts = new TinySeason;
            $ts->tsUId = Auth::user()->id;
            $ts->tsSId = $request->tsSId;
            $ts->tsPlanOrCost = $request->planOrCost;
            $ts->tsSubject = $request->tsSubject;
            $ts->tsDescription = $request->tsDescription;
            $ts->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل ' . $request->tsSubject . ' در فصل ' . Season::find($request->tsSId)->sSubject);
            return \response()->json($this->getAllTinySeasons($request->planOrCost) , 200);
        }
    }

    public function updateTinySeason(Request $request)
    {
        if (TinySeason::where('id' , '<>' , $request->id)
            ->where('tsSId' , '=' , $request->tsSId)
            ->where('tsPlanOrCost' , '=' , $request->planOrCost)
            ->Where('tsSubject' , '=' , $request->tsSubject)
            ->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = TinySeason::find($request->id);
            $ts = TinySeason::find($request->id);
            $ts->tsUId = Auth::user()->id;
            $ts->tsSId = $request->tsSId;
            $ts->tsSubject = $request->tsSubject;
            $ts->tsDescription = $request->tsDescription;
            $ts->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->tsSubject . ') به (' . $ts->tsSubject . ')');
            return \response()->json($this->getAllTinySeasons($request->planOrCost) , 200);
        }
    }

    public function deleteTinySeason(Request $request)
    {
        $ts = TinySeason::find($request->id);
        try {
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->tsSubject);
            return \response()->json($this->getAllTinySeasons($request->tsPlanOrCost) , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllTinySeasons($request->tsPlanOrCost) , 204);
            }
        }
    }

    public function getTinySeasonsWhitSeasonId(Request $request)
    {
        return \response()->json(
            TinySeason::where('tsSId' , '=' , $request->sId)
            ->where('tsPlanOrCost' , '=' , $request->planOrCost)
            ->get()
        );
    }

    public function FetchTinySeasonData(Request $request)
    {
        return \response()->json($this->getAllTinySeasons($request->planOrCost));
    }

    public function getAllTinySeasons($planOrCost)
    {
        $seasons = Season::whereHas('tinySeason' , function ($query) use ($planOrCost){
            return $query->where('tsPlanOrCost' , '=' , $planOrCost);
        })->with(['tinySeason' => function($query)  use ($planOrCost){
            return $query->where('tsPlanOrCost' , '=' , $planOrCost);
        }])->paginate(5);
        return $seasons;
    }

    public function rowDistributionCredit()
    {
        return view('budget::pages.row_distribution_credit.main', ['pageTitle' => 'ردیف توزیع اعتبار',
            'requireJsFile' => 'row_distribution_credit' ]);
    }

    public function titleOfPlans()
    {
        return view('budget::pages.title_of_plans.main', ['pageTitle' => 'عنوان طرح / برنامه',
            'bSeasons' => $bSeasons = BudgetSeason::all(),
            'requireJsFile' => 'title_of_plans' ]);
    }

    public function FetchRowDC(Request $request)
    {
        $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
        return \response()->json($cdr);
    }

    public function registerRowDC(Request $request)
    {

        if (CreditDistributionRow::where('cdSubject' , '=' , $request->rdcSubject)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $cdr = new CreditDistributionRow;
            $cdr->cdUId = Auth::user()->id;
            $cdr->cdPlanOrCost = $request->planOrCost;
            $cdr->cdSubject = $request->rdcSubject;
            $cdr->cdDescription = $request->rdcDescription;
            $cdr->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . $request->rdcSubject);
            $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
            return \response()->json($cdr);
        }
    }

    public function updateRowDC(Request $request)
    {
        if (CreditDistributionRow::where('id' , '<>' , $request->id)->where('cdSubject' , '=' , $request->rdcSubject)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = CreditDistributionRow::find($request->id);
            $cdr = CreditDistributionRow::find($request->id);
            $cdr->cdSubject = $request->rdcSubject;
            $cdr->cdDescription = $request->rdcDescription;
            $cdr->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . $request->rdcSubject . ')');
            $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
            return \response()->json($cdr);
        }
    }

    public function deleteRowDC(Request $request)
    {
        $cdr = CreditDistributionRow::find($request->id);
        try {
            $logTemp = $cdr->cdSubject;
            $cdr->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ردیف توزیع اعتبار ' . $logTemp);
            $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->cdPlanOrCost)->get();
            return \response()->json($cdr , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->cdPlanOrCost)->get();
                return \response()->json($cdr , 204);
            }
        }
    }

    public function getAllHowToRun()
    {
        return \response()->json(
            HowToRun::all()
        );
    }

    public function getAllCreditDistributionRows(Request $request)
    {
        return \response()->json(
            CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get()
        );
    }

    ///////////////////////////////// fiscal year api ////////////////////////////////
    public function fetchFiscalYearData(Request $request)
    {
        return \response()->json($this->getAllFiscallYears());
    }

    public function getAllFiscallYears()
    {
        return FiscalYear::paginate(5);
    }

    public function fiscalYearActivate(Request $request)
    {
        FiscalYear::activate($request->fyId);
        SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find($request->fyId)->fyLabel);
        return \response()->json($this->getAllFiscallYears());
    }

    public function getFyPermissionInBudget(Request $request)
    {
        return \response()->json($this->getBudgetPermissionWithFyId($request->fyId));
    }

    public function getBudgetPermissionWithFyId($fyId)
    {
        return FyPermissionInBudget::where('pbFyId' , '=' , $fyId)->get();
    }

    function changeSectionPermissionState(Request $request)
    {
        switch ($request->section)
        {
            case 'budget':
                FyPermissionInBudget::where('pbFyId' , '=' , $request->fyId)->update(['pbStatus' => $request->state]);
                SystemLog::setBudgetSubSystemAdminLog('تغییر مجوز های سال مالی ' . FiscalYear::where('id' , '=' , $request->fyId)->value('fyLabel') . ' در زیر سیستم بودجه.');
                return \response()->json($this->getBudgetPermissionWithFyId($request->fyId));
        }
    }

    function changeBudgetItemPermissionState(Request $request)
    {
        $fyBudgetPermission = FyPermissionInBudget::find($request->pbId);
        $fyBudgetPermission->pbStatus = $request->state;
        $fyBudgetPermission->save();
        SystemLog::setBudgetSubSystemAdminLog('تغییر مجوز ' . $fyBudgetPermission->pbLabel . ' در سال مالی ' . FiscalYear::where('id' , '=' , $fyBudgetPermission->pbFyId)->value('fyLabel') . ' برای زیر سیستم بودجه.');
        return \response()->json($this->getBudgetPermissionWithFyId($fyBudgetPermission->bpFyId));

    }
}

