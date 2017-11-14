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
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;
use Modules\Budget\Entities\CostSeasonTitle;
use Modules\Budget\Entities\CostTinySeason;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;
use Modules\Budget\Entities\DeprivedArea;
use Modules\Budget\Entities\FyPermissionInBudget;
use Modules\Budget\Entities\HowToRun;
use Modules\Budget\Entities\CapitalAssetsTinySeason;
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
/*    public function deprivedArea()
    {
        $dAreas = DeprivedArea::all();
        return view('budget::pages.deprived_area.main' , ['pageTitle' => 'مناطق محروم' ,
            'dAreas' => $dAreas,
            'requireJsFile' => 'deprived_area']);
    }*/

/*    public function registerDeprivedArea(Request $request)
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
    }*/

/*    public function fiscalYear()
    {
        return view('budget::pages.fiscal_year', ['pageTitle' => 'سال مالی',
            'requireJsFile' => 'fiscal_year']);
    }*/

/*    public function creditDistributionDef()
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
    }*/

/*    public function registerCreditDistributionRow(Request $request)
    {
        $cdr = new CreditDistributionRow;
        $cdr->cdUId = Auth::user()->id;
        $cdr->cdPlanOrCost = 0;
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . Input::get('cdrSubject'));
        return Redirect::to(URL::previous());
    }*/

/*    public function subSeasons()
    {
        $subSeasons = CapitalAssetsTinySeason::select(['tsSId'])->groupBy(['tsSId'])->get();
        $seasons = Season::all();
        return view('budget::pages.sub_seasons.main', ['subSeasons' => $subSeasons,
            'seasons' => $seasons ,
            'requireJsFile' => 'tiny_season',
            'pageTitle' => 'ریز فصول']);
    }*/
    
/*    public function updateCreditDistributionRow(Request $request)
    {
        $old = CreditDistributionRow::find(Input::get('cdrId'));
        $cdr = CreditDistributionRow::find(Input::get('cdrId'));
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . Input::get('cdrSubject') . ')');
        return Redirect::to(URL::previous());
    }*/

/*    public function deleteCreditDistributionRow($cdId)
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
    }*/

/*    public function fiscalYearActivation(Request $request)
    {
        FiscalYear::activation(Input::get('fyId'));
        SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find(Input::get('fyId'))->fyLabel  );
        return Redirect::to(URL::previous());
    }*/

/*    public function DAIsExist($coId , $reId = null , $rdId = null , $viId = null)
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
    }*/

/*    public function DAIsExistForUpdate($daId , $coId , $reId = null , $rdId = null , $viId = null)
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
    }*/

/*    public function CDRIsExist($cdSubject , $cdId = null)
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
    }*/

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

/*    function checkSectionPermissionState($section , $fyId)
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
    }*/

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

/*    public function registerBudgetSeason(Request $request)
    {
        $bs = new BudgetSeason;
        $bs->bsUId = Auth::user()->id;
        $bs->bsSubject = Input::get('bsSubject');
        $bs->bsDescription = Input::get('bsDescription');
        $bs->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف فصل بودجه ' . Input::get('bsSubject'));
        return Redirect::to(URL::previous() . '#budget_season_tab');
    }*/

/*    public function deleteBudgetSeason($bsId)
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
    }*/

/*    public function registerPlanTitle(Request $request)
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
    }*/

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

/*    public function registerSubSeason(Request $request)
    {
        $ts = new CapitalAssetsTinySeason;
        $ts->tsUId = Auth::user()->id;
        $ts->tsSId = Input::get('sId');
        $ts->tsPlanOrCost = 0; //capital assets
        $ts->tsSubject = Input::get('tsSubject');
        $ts->tsDescription = Input::get('tsDescription');
        $ts->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل ' . Input::get('tsSubject') . ' در فصل ' . Season::find(Input::get('sId'))->sSubject);
        return Redirect::to(URL::previous());
    }*/

/*    public function deleteSubSeason($tsId)
    {
        $ts = CapitalAssetsTinySeason::find($tsId);
        try {
            $logTemp = CapitalAssetsTinySeason::find($tsId);
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $logTemp->tsSubject);
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }*/

/*    public function SSIsExist($sId , $tsSubject , $tsId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($tsId == null)
            {
                if (CapitalAssetsTinySeason::where('tsSId' , '=' , $sId)->Where('tsSubject' , '=' , $tsSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
            else{
                if (CapitalAssetsTinySeason::where('id' , '<>' , $tsId)->where('tsSId' , '=' , $sId)->where('tsSubject' , '=' , $tsSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
        }
    }*/

/*    public function updateSubSeason(Request $request)
    {
        $old = CapitalAssetsTinySeason::find(Input::get('tsId'));
        $ts = CapitalAssetsTinySeason::find(Input::get('tsId'));
        $ts->tsSId = Input::get('sId');
        $ts->tsSubject = Input::get('tsSubject');
        $ts->tsDescription = Input::get('tsDescription');
        $ts->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->tsSubject . ') به (' . $ts->tsSubject . ')');
        return Redirect::to(URL::previous() . '#plan_title_tab');
    }*/
    ////////////////////////////// cost tiny season /////////////////////////////////
    public function FetchCostTinySeasonData(Request $request)
    {
        return \response()->json($this->getAllTinySeasons("cost"));
    }

    public function registerCostTinySeason(Request $request)
    {
        if (CostTinySeason::where('ctsCstId' , '=' , $request->stId)
            ->Where('ctsSubject' , '=' , $request->subject)
            ->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $ts = new CostTinySeason;
            $ts->ctsUId = Auth::user()->id;
            $ts->ctsCstId = $request->stId;
            $ts->ctsSubject = $request->subject;
            $ts->ctsDescription = $request->description;
            $ts->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل هزینه ای ' . $request->subject . ' در عنوان فصل ' . CostSeasonTitle::find($request->stId)->catsSubject);
            return \response()->json($this->getAllTinySeasons("cost") , 200);
        }
    }

    public function updateCostTinySeason(Request $request)
    {
        if (CostTinySeason::where('id' , '<>' , $request->id)
            ->where('ctsCstId' , '=' , $request->stId)
            ->Where('ctsSubject' , '=' , $request->subject)
            ->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = CostTinySeason::find($request->id);
            $ts = CostTinySeason::find($request->id);
            $ts->ctsUId = Auth::user()->id;
            $ts->ctsCstId = $request->stId;
            $ts->ctsSubject = $request->subject;
            $ts->ctsDescription = $request->description;
            $ts->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->ctsSubject . ') به (' . $ts->ctsubject . ')');
            return \response()->json($this->getAllTinySeasons("cost") , 200);
        }
    }

    public function deleteCostTinySeason(Request $request)
    {
        $ts = CostTinySeason::find($request->id);
        try {
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->subject);
            return \response()->json($this->getAllTinySeasons("cost") , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllTinySeasons("cost") , 204);
            }
        }
    }

    public function getAllCostTinySeason(Request $request)
    {
        return \response()->json(CostTinySeason::where('ctsCstId' , '=' , $request->cstId)->get());
    }

    ////////////////////////////// capital assets tiny season /////////////////////////////////
    public function getCapitalAssetsTinySeasonsWhitSeasonId(Request $request)
    {
        return \response()->json(
            CapitalAssetsTinySeason::where('tsSId' , '=' , $request->sId)->get()
        );
    }

    public function FetchCapitalAssetsTinySeasonData(Request $request)
    {
        return \response()->json($this->getAllTinySeasons("capitalAssets"));
    }

    public function getAllTinySeasons($type)
    {
        if ($type == "capitalAssets")
        {
            $seasons = Season::with(['capitalAssetsSeasonTitle' => function($q){
                $q->with('capitalAssetsTinySeason')
                    ->has('capitalAssetsTinySeason');
            }])->whereHas('capitalAssetsSeasonTitle' , function ($q){
                $q->whereHas('capitalAssetsTinySeason');
            })->paginate(5);
            return $seasons;
        }else if ($type == "cost")
        {
            $seasons = Season::with(['costSeasonTitle' => function($q){
                $q->with('costTinySeason')
                    ->has('costTinySeason');
            }])->whereHas('costSeasonTitle' , function ($q){
                $q->whereHas('costTinySeason');
            })->paginate(5);
            return $seasons;
        }
    }

    public function getAllCapitalAssetsTinySeason(Request $request)
    {
        return \response()->json(CapitalAssetsTinySeason::where('catsCastId' , '=' , $request->castId)->get());
    }

    public function registerCapitalAssetsTinySeason(Request $request)
    {
        if (CapitalAssetsTinySeason::where('catsCastId' , '=' , $request->stId)
            ->Where('catsSubject' , '=' , $request->subject)
            ->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $ts = new CapitalAssetsTinySeason;
            $ts->catsUId = Auth::user()->id;
            $ts->catsCastId = $request->stId;
            $ts->catsSubject = $request->subject;
            $ts->catsDescription = $request->description;
            $ts->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل عمرانی ' . $request->subject . ' در عنوان فصل ' . CapitalAssetsSeasonTitle::find($request->stId)->castSubject);
            return \response()->json($this->getAllTinySeasons("capitalAssets") , 200);
        }
    }

    public function updateCapitalAssetsTinySeason(Request $request)
    {
        if (CapitalAssetsTinySeason::where('id' , '<>' , $request->id)
            ->where('catsCastId' , '=' , $request->stId)
            ->Where('catsSubject' , '=' , $request->subject)
            ->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = CapitalAssetsTinySeason::find($request->id);
            $ts = CapitalAssetsTinySeason::find($request->id);
            $ts->catsUId = Auth::user()->id;
            $ts->catsCastId = $request->stId;
            $ts->catsSubject = $request->subject;
            $ts->catsDescription = $request->description;
            $ts->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->catsSubject . ') به (' . $ts->catsubject . ')');
            return \response()->json($this->getAllTinySeasons("capitalAssets") , 200);
        }
    }

    public function deleteCapitalAssetsTinySeason(Request $request)
    {
        $ts = CapitalAssetsTinySeason::find($request->id);
        try {
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->subject);
            return \response()->json($this->getAllTinySeasons("capitalAssets") , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllTinySeasons("capitalAssets") , 204);
            }
        }
    }

    public function rowDistributionCredit()
    {
        return view('budget::pages.row_distribution_credit.main', ['pageTitle' => 'ردیف توزیع اعتبار',
            'requireJsFile' => 'row_distribution_credit' ]);
    }

/*    public function titleOfPlans()
    {
        return view('budget::pages.title_of_plans.main', ['pageTitle' => 'عنوان طرح / برنامه',
            'bSeasons' => $bSeasons = BudgetSeason::all(),
            'requireJsFile' => 'title_of_plans' ]);
    }*/

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

/*    public function getAllCreditDistributionRows(Request $request)
    {
        return \response()->json(
            CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get()
        );
    }*/

    ///////////////////////////////// capital assets season title ////////////////////
    public function registerCapitalAssetsSeasonTitle(Request $request)
    {
        $st = new CapitalAssetsSeasonTitle;
        $st->castUId = Auth::user()->id;
        $st->castSId = $request->sId;
        $st->castSubject = $request->subject;
        $st->castDescription = $request->description;
        $st->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان فصل تملک داریی های سرمایه ای ' . $request->subject);
        return \response()->json($this->getAllSeasonTitle("plan"));
    }

    public function updateCapitalAssetsSeasonTitle(Request $request)
    {
        $st = CapitalAssetsSeasonTitle::find($request->id);
        $st->castUId = Auth::user()->id;
        $st->castSId = $request->sId;
        $st->castSubject = $request->subject;
        $st->castDescription = $request->description;
        $st->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان فصل تملک داریی های سرمایه ای ' . $request->subject);
        return \response()->json($this->getAllSeasonTitle("plan"));
    }

    public function fetchCapitalAssetsSeasonTitleData(Request $request)
    {
        return \response()->json($this->getAllSeasonTitle("plan"));
    }

    public function getAllSeasonTitle($pOrC)
    {
        if ($pOrC == "cost")
        {
            return Season::with('costSeasonTitle')->whereHas('costSeasonTitle')->paginate(5);
        }
        else if ($pOrC == "plan")
        {
            return Season::with('capitalAssetsSeasonTitle')->whereHas('capitalAssetsSeasonTitle')->paginate(5);
        }
    }

    public function getCapitalAssetsSeasonTitleWithSId(Request $request)
    {
        return \response()->json(CapitalAssetsSeasonTitle::where('castSId' , '=' , $request->sId)->get());
    }

    public function deleteCapitalAssetsSeasonTitle(Request $request)
    {
        $st = CapitalAssetsSeasonTitle::find($request->id);
        try {
            $st->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان فصل ' . $request->subject);
            return \response()->json($this->getAllSeasonTitle("plan") , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllSeasonTitle("plan") , 204);
            }
        }
    }
    ///////////////////////////////// cost season title ////////////////////
    public function registerCostSeasonTitle(Request $request)
    {
        $st = new CostSeasonTitle;
        $st->cstUId = Auth::user()->id;
        $st->cstSId = $request->sId;
        $st->cstSubject = $request->subject;
        $st->cstDescription = $request->description;
        $st->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان فصل هزینه ای ' . $request->subject);
        return \response()->json($this->getAllSeasonTitle("cost"));
    }

    public function updateCostSeasonTitle(Request $request)
    {
        $st = CostSeasonTitle::find($request->id);
        $st->cstUId = Auth::user()->id;
        $st->cstSId = $request->sId;
        $st->cstSubject = $request->subject;
        $st->cstDescription = $request->description;
        $st->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان فصل هزینه ای ' . $request->subject);
        return \response()->json($this->getAllSeasonTitle("cost"));
    }

    public function fetchCostSeasonTitleData(Request $request)
    {
        return \response()->json($this->getAllSeasonTitle("cost"));
    }

    public function getCostSeasonTitleWithSId(Request $request)
    {
        return \response()->json(CostSeasonTitle::where('cstSId' , '=' , $request->sId)->get());
    }

    public function deleteCostSeasonTitle(Request $request)
    {
        $st = CostSeasonTitle::find($request->id);
        try {
            $st->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان فصل ' . $request->subject);
            return \response()->json($this->getAllSeasonTitle("cost") , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllSeasonTitle("cost") , 204);
            }
        }
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
        return \response()->json($this->getBudgetPermissionWithFyId($fyBudgetPermission->pbFyId));

    }

    /////////////////////////////// deprived area ///////////////////////////////////////////
    public function fetchDeprivedAreaData(Request $request)
    {
        return \response()->json($this->getAllDeprivedArea());
    }

    public function getAllDeprivedArea()
    {
        return DeprivedArea::with('county')
            ->with('region')
            ->with('ruralDistrict')
            ->with('village')
            ->get();
    }

    public function registerDeprivedArea(Request $request)
    {
        if (DeprivedArea::where('daCoId' , '=' , $request->county)->where('daReId' , '=' , $request->region)->where('daRdId' , '=' , $request->ruralDistrict)->where('daViId' , '=' , $request->village)->exists())
        {
            return \response()->json($this->getAllDeprivedArea() , 409);
        }
        else
        {
            $deprivedArea = new DeprivedArea;
            $deprivedArea->daUId = Auth::user()->id;
            $deprivedArea->daCoId = $request->county;
            $deprivedArea->daReId = $request->region;
            $deprivedArea->daRdId = $request->ruralDistrict;
            $deprivedArea->daViId = $request->village;
            $deprivedArea->daDescription = $request->description;
            $deprivedArea->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف منطقه محروم ' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id));
            return \response()->json($this->getAllDeprivedArea());
        }

    }

    public function updateDeprivedArea(Request $request)
    {
        if (DeprivedArea::where('id' , '<>' , $request->id)->where('daCoId' , '=' , $request->county)->where('daReId' , '=' , $request->region)->where('daRdId' , '=' , $request->ruralDistrict)->where('daViId' , '=' , $request->village)->exists())
        {
            return \response()->json($this->getAllDeprivedArea() , 409);
        }
        else
        {
            $old = DeprivedArea::getDeprivedAreaLabel($request->id);
            $deprivedArea = DeprivedArea::find($request->id);
            $deprivedArea->daCoId = $request->county;
            $deprivedArea->daReId = $request->region;
            $deprivedArea->daRdId = $request->ruralDistrict;
            $deprivedArea->daViId = $request->village;
            $deprivedArea->daDescription = $request->description;
            $deprivedArea->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر در منطقه محروم (' . $old . ') به (' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id) . ')');
            return \response()->json($this->getAllDeprivedArea());
        }
    }

    public function deleteDeprivedArea(Request $request)
    {
        $deprivedArea = DeprivedArea::find($request->id);
        try {
            $logTemp = DeprivedArea::getDeprivedAreaLabel($request->id);
            $deprivedArea->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف منطقه محروم ' . $logTemp);
            return \response()->json($this->getAllDeprivedArea());
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllDeprivedArea() , 204);
            }
        }
    }

    /////////////////////////////// budget season /////////////////////////////////////////
    public function fetchBudgetSeasonData(Request $request)
    {
        return \response()->json($this->getAllBudgetSeasons());
    }

    public function getAllBudgetSeasons()
    {
        return BudgetSeason::all();
    }

    public function registerBudgetSeason(Request $request)
    {
        if (BudgetSeason::where('bsSubject' , '=' , $request->subject)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $bs = new BudgetSeason;
            $bs->bsUId = Auth::user()->id;
            $bs->bsSubject = $request->subject;
            $bs->bsDescription = $request->description;
            $bs->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف فصل بودجه ' . $request->subject);
            return \response()->json($this->getAllBudgetSeasons());
        }

    }

    public function updateBudgetSeason(Request $request)
    {
        if (BudgetSeason::where('id' , '<>' , $request->id)->where('bsSubject' , '=' , $request->subject)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = BudgetSeason::find($request->id);
            $bs = BudgetSeason::find($request->id);
            $bs->bsSubject = $request->subject;
            $bs->bsDescription = $request->description;
            $bs->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر در فصل بودجه (' . $old->bsSubject . ') به (' . $bs->bsSubject . ')');
            return \response()->json($this->getAllBudgetSeasons());
        }
    }

    public function deleteBudgetSeason(Request $request)
    {
        $bs = BudgetSeason::find($request->id);
        try {
            $logTemp = BudgetSeason::find($request->id);
            $bs->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف فصل بودجه ' . $logTemp->bsSubject);
            return \response()->json($this->getAllBudgetSeasons());
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }

    //////////////////////////////// credit distribution rows //////////////////////////////
    public function fetchCreditDistributionRowsData(Request $request)
    {
        return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
    }

    public function getAllCreditDistributionRows($planOrCost)
    {
        return CreditDistributionRow::where('cdPlanOrCost' , $planOrCost)->get();

    }

    public function getAllCDRItems(Request $request)
    {
        return \response()->json(CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get());
    }

    public function registerCreditDistributionRow(Request $request)
    {
        if (CreditDistributionRow::where('cdSubject' , '=' , $request->subject)
            ->where('cdPlanOrCost' , '=' , $request->planOrCost)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $cdr = new CreditDistributionRow;
            $cdr->cdUId = Auth::user()->id;
            $cdr->cdPlanOrCost = $request->planOrCost;
            $cdr->cdSubject = $request->subject;
            $cdr->cdDescription = $request->description;
            $cdr->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . $request->subject);
            return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
        }
    }

    public function updateCreditDistributionRow(Request $request)
    {
        if (CreditDistributionRow::where('id' , '<>' , $request->id)
            ->where('cdSubject' , '=' , $request->subject)
            ->where('cdPlanOrCost' , '=' , $request->planOrCost)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = CreditDistributionRow::find($request->id);
            $cdr = CreditDistributionRow::find($request->id);
            $cdr->cdSubject = $request->subject;
            $cdr->cdDescription = $request->description;
            $cdr->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . $request->subject . ')');
            return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
        }
    }

    public function deleteCreditDistributionRow(Request $request)
    {
        $cdr = CreditDistributionRow::find($request->crId);
        try {
            $logTemp = $cdr->cdSubject;
            $cdr->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ردیف توزیع اعتبار ' . $logTemp);
            return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }
    ////////////////////////////// credit distribution plan or cost title ////////////////////
    public function registerPlanOrCostTitle(Request $request)
    {
        $cdpt = new CreditDistributionTitle;
        $cdpt->cdtUId = Auth::user()->id;
        $cdpt->cdtBsId = $request->bsId;
        $cdpt->cdtIdNumber = $request->code;
        $cdpt->cdtSubject = $request->subject;
        $cdpt->cdtDescription = $request->description;
        $cdpt->save();

        $counties = County::all();
        foreach ($counties as $county)
        {
            if (isset($request['county' . $county->id]))
            {
                $cdpt_co = new CreditDistributionTitle;
                $cdpt_co->cdtUId = Auth::user()->id;
                $cdpt_co->cdtBsId = $request->bsId;
                $cdpt_co->cdtIdNumber = $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $request->code;
                $cdpt_co->cdtSubject = $request->subject;
                if (isset($request['countyDesc' . $county->id]))
                    $cdpt_co->cdtDescription = $request['countyDesc' . $county->id];
                $cdpt_co->cdtCoId = $county->id;
                $cdpt_co->cdtCdtId = $cdpt->id;
                $cdpt_co->save();
                SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان طرح توزیع اعتبار در سطح شهرستان ' . $county->coName);
            }
        }

        SystemLog::setBudgetSubSystemAdminLog('تعریف طرح / برنامه توزیع اعتبار با عنوان ' . $request->subject);
        return \response()->json($this->getAllPlanOrCostTitle());
    }

    public function getAllPlanOrCostTitle()
    {
        return CreditDistributionTitle::where('cdtCoId' , '=' , null)
            ->with('budgetSeason')
            ->with('CDTInCounty')
            ->with('CDTInCounty.county')
            ->paginate(5);
    }

    public function fetchPlanOrCostTitleData()
    {
        return \response()->json($this->getAllPlanOrCostTitle());
    }

    public function getAllPlanOrCostTitleItem(Request $request)
    {
        if (isset($request->bsId))
        {
            if ($request->pOrN)
            {
                return \response()->json(CreditDistributionTitle::with('county')
                    ->where('cdtCoId' , '=' , null)
                    ->where('cdtBsId' , '=' , $request->bsId)
                    ->get());
            }
            else
            {
                return \response()->json(CreditDistributionTitle::with('county')
                    ->where('cdtCoId' , '<>' , null)
                    ->where('cdtBsId' , '=' , $request->bsId)
                    ->get());
            }
        }
        else{
            if ($request->pOrN)
            {
                return \response()->json(CreditDistributionTitle::with('county')
                    ->where('cdtCoId' , '=' , null)
                    ->get());
            }
            else
            {
                return \response()->json(CreditDistributionTitle::with('county')
                    ->where('cdtCoId' , '<>' , null)
                    ->get());
            }
        }
    }
}

