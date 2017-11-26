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
use Modules\Admin\Entities\User;
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
    ////////////////////////////// cost tiny season /////////////////////////////////
    public function FetchCostTinySeasonData(Request $request)
    {
        return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage));
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
            return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage));
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
            return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage));
        }
    }

    public function deleteCostTinySeason(Request $request)
    {
        $ts = CostTinySeason::find($request->id);
        try {
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->subject);
            return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage) , 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage) , 204);
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
        return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
    }

    public function getAllTinySeasons($type , $searchValue , $itemInPage)
    {
        if ($type == "capitalAssets")
        {
            return Season::with(['capitalAssetsSeasonTitle.capitalAssetsTinySeason' => function($query) use ($searchValue){
                return $query->where('catsSubject' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('catsDescription' , 'LIKE' , '%' . $searchValue . '%');
                    }])
                    ->whereHas('capitalAssetsSeasonTitle.capitalAssetsTinySeason' , function ($query) use ($searchValue){
                        return $query->where('catsSubject' , 'LIKE' , '%' . $searchValue . '%')
                            ->orWhere('catsDescription' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->paginate($itemInPage);

        }else if ($type == "cost")
        {
            return Season::with(['costSeasonTitle.costTinySeason' => function($query) use ($searchValue){
                return $query->where('ctsSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('ctsDescription' , 'LIKE' , '%' . $searchValue . '%');
                    }])
                    ->whereHas('costSeasonTitle.costTinySeason' , function ($query) use ($searchValue){
                        return $query->where('ctsSubject' , 'LIKE' , '%' . $searchValue . '%')
                            ->orWhere('ctsDescription' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->paginate($itemInPage);
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
            return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
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
            return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
        }
    }

    public function deleteCapitalAssetsTinySeason(Request $request)
    {
        $ts = CapitalAssetsTinySeason::find($request->id);
        try {
            $ts->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->subject);
            return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage) , 204);
            }
        }
    }

    public function rowDistributionCredit()
    {
        return view('budget::pages.row_distribution_credit.main', ['pageTitle' => 'ردیف توزیع اعتبار',
            'requireJsFile' => 'row_distribution_credit' ]);
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
        return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
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
        return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
    }

    public function fetchCapitalAssetsSeasonTitleData(Request $request)
    {
        return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
    }

    public function getAllSeasonTitle($pOrC , $searchValue , $itemInPage)
    {
        if ($pOrC == "cost")
        {
            return Season::with(['costSeasonTitle' => function ($query) use ($searchValue){
                return $query->where('cstSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cstDescription' , 'LIKE' , '%' . $searchValue . '%');
                }])
                ->whereHas('costSeasonTitle' , function ($query) use ($searchValue){
                    return $query->where('cstSubject' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('cstDescription' , 'LIKE' , '%' . $searchValue . '%');
                })
                ->paginate($itemInPage);
        }
        else if ($pOrC == "plan")
        {
            return Season::with(['capitalAssetsSeasonTitle' => function ($query) use ($searchValue){
                return $query->where('castSubject' , 'LIKE' ,  '%' . $searchValue . '%')
                    ->orWhere('castDescription' , 'LIKE' , '%' . $searchValue . '%');
                }])
                ->whereHas('capitalAssetsSeasonTitle' , function ($query) use ($searchValue){
                    return $query->where('castSubject' , 'LIKE' , '%' . $searchValue . '%')
                                 ->orWhere('castDescription' , 'LIKE' , '%' . $searchValue . '%');
                })
                ->paginate($itemInPage);
        }
    }

    public function getCapitalAssetsSeasonTitleWithSId(Request $request)
    {
        return \response()->json(CapitalAssetsSeasonTitle::where('castSId' , '=' , $request->sId)->get());
    }

    public function deleteCapitalAssetsSeasonTitle(Request $request)
    {
        $st = CapitalAssetsSeasonTitle::find($request->id);
        $subject = $st->castSubject;
        try {
            $st->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان فصل ' . $subject);
            return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
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
        return \response()->json($this->getAllSeasonTitle("cost" , $request->searchValue , $request->itemInPage));
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
        return \response()->json($this->getAllSeasonTitle("cost" , $request->searchValue , $request->itemInPage));
    }

    public function fetchCostSeasonTitleData(Request $request)
    {
        return \response()->json($this->getAllSeasonTitle("cost" , $request->searchValue , $request->itemInPage));
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
            return \response()->json($this->getAllSeasonTitle("cost" , $request->searchValue , $request->itemInPage));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }
    ///////////////////////////////// fiscal year api ////////////////////////////////
    public function fetchFiscalYearData(Request $request)
    {
        return \response()->json($this->getAllFiscalYears());
    }

    public function getAllFiscalYears()
    {
        return FiscalYear::paginate(10);
    }

    public function fetchAllFiscalYears(Request $request)
    {
        return FiscalYear::where('fyStatus' , '<>' , 0)->get();
    }

    public function fiscalYearActivate(Request $request)
    {
        FiscalYear::activate($request->fyId);
        SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find($request->fyId)->fyLabel);
        return \response()->json($this->getAllFiscalYears());
    }

    public function changeFiscalYear(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->seFiscalYear = $request->fyId;
        $user->save();
        return \request()->json([]);
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
        if (CreditDistributionTitle::where('cdtIdNumber' , '=' , $request->code)->exists())
        {
            return \response()->json([] , 409);
        }
        else
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
            return \response()->json($this->getAllPlanOrCostTitle($request->searchValue , $request->itemInPage));
        }
    }

    public function updatePlanTitle(Request $request)
    {

        if (CreditDistributionTitle::where('id' , '<>' , $request->id)
            ->where('cdtIdNumber' , '=' , $request->code)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = CreditDistributionTitle::find($request->id);
            $cdpt = CreditDistributionTitle::find($request->id);
            $cdpt->cdtUId = Auth::user()->id;
            $cdpt->cdtBsId = $request->bsId;
            $cdpt->cdtIdNumber = $request->code;
            $cdpt->cdtSubject = $request->subject;
            $cdpt->cdtDescription = $request->description;
            $cdpt->save();

            $counties = County::all();
            foreach ($counties as $county)
            {
                $cdtP = CreditDistributionTitle::where('cdtCdtId' , $cdpt->id);
                if ($request['county' . $county->id] != '')
                {
                    if ($cdtP->where('cdtIdNumber' , '=' , $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $cdpt->cdtIdNumber)->exists())
                    {
                        $cdtP->where('cdtIdNumber' , '=' , $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $cdpt->cdtIdNumber)->update(['cdtIdNumber' => Uuid::uuid4() . Auth::user()->id]);
                    }
                    CreditDistributionTitle::updateOrCreate(['cdtCdtId' => $request->id , 'cdtCoId' => $county->id] , ['cdtUId' => Auth::user()->id,
                        'cdtBsId' => $request->bsId,
                        'cdtIdNumber' => $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $request->code,
                        'cdtSubject' => $request->subject,
                        'cdtDescription' => isset($request['countyDesc' . $county->id]) ? $request['countyDesc' . $county->id] : '',
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
            return \response()->json($this->getAllPlanOrCostTitle($request->searchValue , $request->itemInPage));
        }
    }

    public function deletePlanTitle(Request $request)
    {
        try {
            $logTemp = CreditDistributionTitle::find($request->id);
            CreditDistributionTitle::where('cdtCdtId' , '=' , $request->id)->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار در سطح شهرستان با عنوان ' . $logTemp->cdptSubject);

            $cdpt = CreditDistributionTitle::find($request->id);
            $cdpt->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار ' . $logTemp->cdptSubject);
            return \response()->json($this->getAllPlanOrCostTitle($request->searchValue , $request->itemInPage));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }

    public function getAllPlanOrCostTitle($searchValue , $itemInPage)
    {
        return CreditDistributionTitle::where('cdtCoId' , '=' , null)
            ->where(function($q) use($searchValue){
                $q->where('cdtIdNumber' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cdtSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cdtDescription' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->with('budgetSeason')
            ->with('CDTInCounty')
            ->with('CDTInCounty.county')
            ->paginate($itemInPage);
    }

    public function fetchPlanOrCostTitleData(Request $request)
    {
        return \response()->json($this->getAllPlanOrCostTitle($request->searchValue , $request->itemInPage));
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

