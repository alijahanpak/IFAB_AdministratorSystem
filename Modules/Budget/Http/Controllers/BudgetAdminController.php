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
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\Season;
use Modules\Admin\Entities\SubSystem;
use Modules\Admin\Entities\SubSystemPart;
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
use Modules\Budget\Entities\PermissionLimiter;
use Ramsey\Uuid\Uuid;

class BudgetAdminController extends Controller
{
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
        $result = DB::transaction(function () use($request){
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
                $ts->ctsSubject = PublicSetting::checkPersianCharacters($request->subject);
                $ts->ctsDescription = PublicSetting::checkPersianCharacters($request->description);
                $ts->save();

                SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل هزینه ای ' . $request->subject . ' در عنوان فصل ' . CostSeasonTitle::find($request->stId)->catsSubject);
                return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage));
            }
        });
        return $result;
    }

    public function updateCostTinySeason(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (CostTinySeason::where('id' , '<>' , $request->id)
                ->where('ctsCstId' , '=' , $request->stId)
                ->Where('ctsSubject' , '=' , PublicSetting::checkPersianCharacters($request->subject))
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
                $ts->ctsSubject = PublicSetting::checkPersianCharacters($request->subject);
                $ts->ctsDescription = PublicSetting::checkPersianCharacters($request->description);
                $ts->save();

                SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->ctsSubject . ') به (' . $ts->ctsubject . ')');
                return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage));
            }
        });
        return $result;
    }

    public function deleteCostTinySeason(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $ts = CostTinySeason::find($request->id);
            try {
                $ts->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->subject);
                return \response()->json($this->getAllTinySeasons("cost" , $request->searchValue , $request->itemInPage));
            }
            catch (\Illuminate\Database\QueryException $e) {
                if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                    return \response()->json([] , 204);
                }
            }
        });
        return $result;
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
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        if ($type == "capitalAssets")
        {
            return Season::with('capitalAssetsSeasonTitleHasTinySeason.capitalAssetsTinySeason')
                    ->whereHas('capitalAssetsSeasonTitleHasTinySeason.capitalAssetsTinySeason' , function ($query) use ($searchValue){
                        return $query->where('catsSubject' , 'LIKE' , '%' . $searchValue . '%')
                            ->orWhere('catsDescription' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->paginate($itemInPage);

        }else if ($type == "cost")
        {
            return Season::with('costSeasonTitleHasTinySeason.costTinySeason')
                    ->whereHas('costSeasonTitleHasTinySeason.costTinySeason' , function ($query) use ($searchValue){
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
        $result = DB::transaction(function () use($request){
            if (CapitalAssetsTinySeason::where('catsCastId' , '=' , $request->stId)
                ->Where('catsSubject' , '=' , PublicSetting::checkPersianCharacters($request->subject))
                ->exists())
            {
                return \response()->json([] , 409);
            }
            else
            {
                $ts = new CapitalAssetsTinySeason;
                $ts->catsUId = Auth::user()->id;
                $ts->catsCastId = $request->stId;
                $ts->catsSubject = PublicSetting::checkPersianCharacters($request->subject);
                $ts->catsDescription = PublicSetting::checkPersianCharacters($request->description);
                $ts->save();

                SystemLog::setBudgetSubSystemAdminLog('تعریف ریز فصل عمرانی ' . $request->subject . ' در عنوان فصل ' . CapitalAssetsSeasonTitle::find($request->stId)->castSubject);
                return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
            }
        });
        return $result;
    }

    public function updateCapitalAssetsTinySeason(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (CapitalAssetsTinySeason::where('id' , '<>' , $request->id)
                ->where('catsCastId' , '=' , $request->stId)
                ->Where('catsSubject' , '=' , PublicSetting::checkPersianCharacters($request->subject))
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
                $ts->catsSubject = PublicSetting::checkPersianCharacters($request->subject);
                $ts->catsDescription = PublicSetting::checkPersianCharacters($request->description);
                $ts->save();

                SystemLog::setBudgetSubSystemAdminLog('تغییر  ریز فصل (' . $old->catsSubject . ') به (' . $ts->catsubject . ')');
                return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
            }
        });
        return $result;
    }

    public function deleteCapitalAssetsTinySeason(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $ts = CapitalAssetsTinySeason::find($request->id);
            try {
                $ts->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف ریز فصل ' . $request->subject);
                return \response()->json($this->getAllTinySeasons("capitalAssets" , $request->searchValue , $request->itemInPage));
            }
            catch (\Illuminate\Database\QueryException $e) {
                if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                    return \response()->json([] , 204);
                }
            }
        });
        return $result;
    }

    public function FetchRowDC(Request $request)
    {
        $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
        return \response()->json($cdr);
    }

    public function registerRowDC(Request $request)
    {
        $result = DB::transaction(function () use($request){
            return \response()->json([] , 409);
            if (CreditDistributionRow::where('cdSubject' , '=' , PublicSetting::checkPersianCharacters($request->rdcSubject))->exists())
            {
                return \response()->json([] , 409);
            }
            else
            {
                $cdr = new CreditDistributionRow;
                $cdr->cdUId = Auth::user()->id;
                $cdr->cdPlanOrCost = $request->planOrCost;
                $cdr->cdSubject = PublicSetting::checkPersianCharacters($request->rdcSubject);
                $cdr->cdDescription = PublicSetting::checkPersianCharacters($request->rdcDescription);
                $cdr->save();

                SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . $request->rdcSubject);
                $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
                return \response()->json($cdr);
            }
        });
        return $result;
    }

    public function updateRowDC(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (CreditDistributionRow::where('id' , '<>' , $request->id)->where('cdSubject' , '=' , PublicSetting::checkPersianCharacters($request->rdcSubject))->exists())
            {
                return \response()->json([] , 409);
            }
            else
            {
                $old = CreditDistributionRow::find($request->id);
                $cdr = CreditDistributionRow::find($request->id);
                $cdr->cdSubject = PublicSetting::checkPersianCharacters($request->rdcSubject);
                $cdr->cdDescription = PublicSetting::checkPersianCharacters($request->rdcDescription);
                $cdr->save();

                SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . $request->rdcSubject . ')');
                $cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
                return \response()->json($cdr);
            }
        });
        return $result;
    }

    public function deleteRowDC(Request $request)
    {
        $result = DB::transaction(function () use($request){
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
                    return \response()->json([] , 204);
                }
            }
        });
        return $result;
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
        DB::transaction(function () use($request){
            $st = new CapitalAssetsSeasonTitle;
            $st->castUId = Auth::user()->id;
            $st->castSId = $request->sId;
            $st->castSubject = PublicSetting::checkPersianCharacters($request->subject);
            $st->castDescription = PublicSetting::checkPersianCharacters($request->description);
            $st->save();
            SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان فصل تملک داریی های سرمایه ای ' . $request->subject);
        });

        return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
    }

    public function updateCapitalAssetsSeasonTitle(Request $request)
    {
        DB::transaction(function () use($request) {
            $st = CapitalAssetsSeasonTitle::find($request->id);
            $st->castUId = Auth::user()->id;
            $st->castSId = $request->sId;
            $st->castSubject = PublicSetting::checkPersianCharacters($request->subject);
            $st->castDescription = PublicSetting::checkPersianCharacters($request->description);
            $st->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان فصل تملک داریی های سرمایه ای ' . $request->subject);
        });
        return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
    }

    public function fetchCapitalAssetsSeasonTitleData(Request $request)
    {
        return \response()->json($this->getAllSeasonTitle("plan" , $request->searchValue , $request->itemInPage));
    }

    public function getAllSeasonTitle($pOrC , $searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
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
        $result = DB::transaction(function () use($request){
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
        });
        return $result;
    }
    ///////////////////////////////// cost season title ////////////////////
    public function registerCostSeasonTitle(Request $request)
    {
        DB::transaction(function () use($request){
            $st = new CostSeasonTitle;
            $st->cstUId = Auth::user()->id;
            $st->cstSId = $request->sId;
            $st->cstSubject = PublicSetting::checkPersianCharacters($request->subject);
            $st->cstDescription = PublicSetting::checkPersianCharacters($request->description);
            $st->save();

            SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان فصل هزینه ای ' . $request->subject);
        });

        return \response()->json($this->getAllSeasonTitle("cost" , $request->searchValue , $request->itemInPage));
    }

    public function updateCostSeasonTitle(Request $request)
    {
        DB::transaction(function () use($request) {
            $st = CostSeasonTitle::find($request->id);
            $st->cstUId = Auth::user()->id;
            $st->cstSId = $request->sId;
            $st->cstSubject = PublicSetting::checkPersianCharacters($request->subject);
            $st->cstDescription = PublicSetting::checkPersianCharacters($request->description);
            $st->save();

            SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان فصل هزینه ای ' . $request->subject);
        });

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
        $result = DB::transaction(function () use($request){
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
        });
        return $result;
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
        DB::transaction(function () use($request){
            FiscalYear::activate($request->fyId);
            SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find($request->fyId)->fyLabel);
        });

        return \response()->json($this->getAllFiscalYears());
    }

    public function changeFiscalYear(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->seFiscalYear = $request->fyId;
        $user->save();
        return \request()->json([]);
    }

    function changeAllPermissionState(Request $request)
    {
        DB::transaction(function () use($request){
            if ($request->state)
            {
                PermissionLimiter::where('plFyId' , $request->fyId)
                    ->delete();
            }else{
                $pers = Permission::where('pAllowDispInFyList' , '=' , true)->get();
                foreach ($pers as $per)
                {
                    $pLimiter = new PermissionLimiter();
                    $pLimiter->plFyId = $request->fyId;
                    $pLimiter->plPId = $per->id;
                    $pLimiter->save();
                }
            }
            $permLimitId = PermissionLimiter::where('plFyId' , $request->fyId)
                ->pluck('plPId');
            $openCount = Permission::whereNotIn('id' , $permLimitId)
                ->where('pAllowDispInFyList' , true)
                ->exists();
            if ($openCount == 0)
            {
                $fy = FiscalYear::where('id' , $request->fyId)->first();
                $fy->fyStatus = 2;
                $fy->save();
            }else{
                $fy = FiscalYear::where('id' , $request->fyId)->first();
                $fy->fyStatus = 1;
                $fy->save();
            }

            SystemLog::setBudgetSubSystemAdminLog('محدود کردن کلیه مجوز های سال مالی ' . FiscalYear::find($request->fyId)->fyLabel);
        });

        return \response()->json($this->getAllFiscalYears());
    }

    function changePermissionState(Request $request)
    {
        DB::transaction(function () use($request){
            if ($request->state)
            {
                PermissionLimiter::where('plFyId' , '=' , $request->fyId)
                    ->where('plPId' , '=' , $request->pId)
                    ->delete();
            }else{
                $pLimiter = new PermissionLimiter();
                $pLimiter->plFyId = $request->fyId;
                $pLimiter->plPId = $request->pId;
                $pLimiter->save();
            }

            $permLimitId = PermissionLimiter::where('plFyId' , $request->fyId)
                ->pluck('plPId');
            $openCount = Permission::whereNotIn('id' , $permLimitId)
                ->where('pAllowDispInFyList' , true)
                ->exists();
            if ($openCount == 0)
            {
                $fy = FiscalYear::where('id' , $request->fyId)->first();
                $fy->fyStatus = 2;
                $fy->save();
            }else{
                $fy = FiscalYear::where('id' , $request->fyId)->first();
                $fy->fyStatus = 1;
                $fy->save();
            }
            SystemLog::setBudgetSubSystemAdminLog('محدود کردن مجوز ' . Permission::find($request->pId)->pSubject . ' در سال مالی ' . FiscalYear::find($request->fyId)->fyLabel);
        });
        return \response()->json($this->getAllFiscalYears());
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
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function registerDeprivedArea(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (DeprivedArea::where('daCoId' , '=' , $request->county)
                ->where('daReId' , '=' , $request->region)
                ->where('daRdId' , '=' , $request->ruralDistrict)
                ->where('daViId' , '=' , $request->village)->exists())
            {
                return \response()->json([] , 409);
            }
            else
            {
                $deprivedArea = new DeprivedArea;
                $deprivedArea->daUId = Auth::user()->id;
                $deprivedArea->daCoId = $request->county;
                $deprivedArea->daReId = $request->region;
                $deprivedArea->daRdId = $request->ruralDistrict;
                $deprivedArea->daViId = $request->village;
                $deprivedArea->daDescription = PublicSetting::checkPersianCharacters($request->description);
                $deprivedArea->save();

                SystemLog::setBudgetSubSystemAdminLog('تعریف منطقه محروم ' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id));
                return \response()->json($this->getAllDeprivedArea());
            }
        });
        return $result;
    }

    public function updateDeprivedArea(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (DeprivedArea::where('id', '<>', $request->id)
                ->where('daCoId', '=', $request->county)
                ->where('daReId', '=', $request->region)
                ->where('daRdId', '=', $request->ruralDistrict)
                ->where('daViId', '=', $request->village)->exists()) {
                return \response()->json([], 409);
            } else {
                $old = DeprivedArea::getDeprivedAreaLabel($request->id);
                $deprivedArea = DeprivedArea::find($request->id);
                $deprivedArea->daCoId = $request->county;
                $deprivedArea->daReId = $request->region;
                $deprivedArea->daRdId = $request->ruralDistrict;
                $deprivedArea->daViId = $request->village;
                $deprivedArea->daDescription = PublicSetting::checkPersianCharacters($request->description);
                $deprivedArea->save();

                SystemLog::setBudgetSubSystemAdminLog('تغییر در منطقه محروم (' . $old . ') به (' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id) . ')');
                return \response()->json($this->getAllDeprivedArea());
            }
        });

        return $result;
    }

    public function deleteDeprivedArea(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            $deprivedArea = DeprivedArea::find($request->id);
            try {
                $logTemp = DeprivedArea::getDeprivedAreaLabel($request->id);
                $deprivedArea->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف منطقه محروم ' . $logTemp);
                return \response()->json($this->getAllDeprivedArea());
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
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
        $result = DB::transaction(function () use($request) {
            if (BudgetSeason::where('bsSubject', '=', $request->subject)->exists()) {
                return \response()->json([], 409);
            } else {
                $bs = new BudgetSeason;
                $bs->bsUId = Auth::user()->id;
                $bs->bsSubject = PublicSetting::checkPersianCharacters($request->subject);
                $bs->bsDescription = PublicSetting::checkPersianCharacters($request->description);
                $bs->save();

                SystemLog::setBudgetSubSystemAdminLog('تعریف فصل بودجه ' . $request->subject);
                return \response()->json($this->getAllBudgetSeasons());
            }
        });
        return $result;
    }

    public function updateBudgetSeason(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (BudgetSeason::where('id', '<>', $request->id)
                ->where('bsSubject', '=', PublicSetting::checkPersianCharacters($request->subject))->exists()) {
                return \response()->json([], 409);
            } else {
                $old = BudgetSeason::find($request->id);
                $bs = BudgetSeason::find($request->id);
                $bs->bsSubject = PublicSetting::checkPersianCharacters($request->subject);
                $bs->bsDescription = PublicSetting::checkPersianCharacters($request->description);
                $bs->save();

                SystemLog::setBudgetSubSystemAdminLog('تغییر در فصل بودجه (' . $old->bsSubject . ') به (' . $bs->bsSubject . ')');
                return \response()->json($this->getAllBudgetSeasons());
            }
        });
        return $result;
    }

    public function deleteBudgetSeason(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            $bs = BudgetSeason::find($request->id);
            try {
                $logTemp = BudgetSeason::find($request->id);
                $bs->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف فصل بودجه ' . $logTemp->bsSubject);
                return \response()->json($this->getAllBudgetSeasons());
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
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
        $result = DB::transaction(function () use($request) {
            if (CreditDistributionRow::where('cdSubject', '=', PublicSetting::checkPersianCharacters($request->subject))
                ->where('cdPlanOrCost', '=', $request->planOrCost)->exists()) {
                return \response()->json([], 409);
            } else {
                $cdr = new CreditDistributionRow;
                $cdr->cdUId = Auth::user()->id;
                $cdr->cdPlanOrCost = $request->planOrCost;
                $cdr->cdSubject = PublicSetting::checkPersianCharacters($request->subject);
                $cdr->cdDescription = PublicSetting::checkPersianCharacters($request->description);
                $cdr->save();

                SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . $request->subject);
                return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
            }
        });
        return $result;
    }

    public function updateCreditDistributionRow(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CreditDistributionRow::where('id', '<>', $request->id)
                ->where('cdSubject', '=', PublicSetting::checkPersianCharacters($request->subject))
                ->where('cdPlanOrCost', '=', PublicSetting::checkPersianCharacters($request->planOrCost))
                ->exists()) {
                return \response()->json([], 409);
            } else {
                $old = CreditDistributionRow::find($request->id);
                $cdr = CreditDistributionRow::find($request->id);
                $cdr->cdSubject = PublicSetting::checkPersianCharacters($request->subject);
                $cdr->cdDescription = PublicSetting::checkPersianCharacters($request->description);
                $cdr->save();

                SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . $request->subject . ')');
                return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
            }
        });
        return $result;
    }

    public function deleteCreditDistributionRow(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            $cdr = CreditDistributionRow::find($request->crId);
            try {
                $logTemp = $cdr->cdSubject;
                $cdr->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف ردیف توزیع اعتبار ' . $logTemp);
                return \response()->json($this->getAllCreditDistributionRows($request->planOrCost));
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
    }
    ////////////////////////////// credit distribution plan or cost title ////////////////////
    public function registerPlanOrCostTitle(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CreditDistributionTitle::where('cdtIdNumber', '=', $request->code)->exists()) {
                return \response()->json([], 409);
            } else {
                $cdpt = new CreditDistributionTitle;
                $cdpt->cdtUId = Auth::user()->id;
                $cdpt->cdtBsId = $request->bsId;
                $cdpt->cdtIdNumber = $request->code;
                $cdpt->cdtSubject = PublicSetting::checkPersianCharacters($request->subject);
                $cdpt->cdtDescription = PublicSetting::checkPersianCharacters($request->description);
                $cdpt->save();

                $counties = County::all();
                foreach ($counties as $county) {
                    if (isset($request['county' . $county->id])) {
                        $cdpt_co = new CreditDistributionTitle;
                        $cdpt_co->cdtUId = Auth::user()->id;
                        $cdpt_co->cdtBsId = $request->bsId;
                        $cdpt_co->cdtIdNumber = $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $request->code;
                        $cdpt_co->cdtSubject = PublicSetting::checkPersianCharacters($request->subject);
                        if (isset($request['countyDesc' . $county->id]))
                            $cdpt_co->cdtDescription = PublicSetting::checkPersianCharacters($request['countyDesc' . $county->id]);
                        $cdpt_co->cdtCoId = $county->id;
                        $cdpt_co->cdtCdtId = $cdpt->id;
                        $cdpt_co->save();
                        SystemLog::setBudgetSubSystemAdminLog('تعریف عنوان طرح توزیع اعتبار در سطح شهرستان ' . $county->coName);
                    }
                }

                SystemLog::setBudgetSubSystemAdminLog('تعریف طرح / برنامه توزیع اعتبار با عنوان ' . $request->subject);
                return \response()->json($this->getAllPlanOrCostTitle($request->searchValue, $request->itemInPage));
            }
        });
        return $result;
    }

    public function updatePlanTitle(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CreditDistributionTitle::where('id', '<>', $request->id)
                ->where('cdtIdNumber', '=', $request->code)->exists()) {
                return \response()->json([], 409);
            } else {
                $old = CreditDistributionTitle::find($request->id);
                $cdpt = CreditDistributionTitle::find($request->id);
                $cdpt->cdtUId = Auth::user()->id;
                $cdpt->cdtBsId = $request->bsId;
                $cdpt->cdtIdNumber = $request->code;
                $cdpt->cdtSubject = PublicSetting::checkPersianCharacters($request->subject);
                $cdpt->cdtDescription = PublicSetting::checkPersianCharacters($request->description);
                $cdpt->save();

                $counties = County::all();
                foreach ($counties as $county) {
                    $cdtP = CreditDistributionTitle::where('cdtCdtId', $cdpt->id);
                    if ($request['county' . $county->id] != '') {
                        if ($cdtP->where('cdtIdNumber', '=', $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $cdpt->cdtIdNumber)->exists()) {
                            $cdtP->where('cdtIdNumber', '=', $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $cdpt->cdtIdNumber)->update(['cdtIdNumber' => Uuid::uuid4() . Auth::user()->id]);
                        }
                        CreditDistributionTitle::updateOrCreate(['cdtCdtId' => $request->id, 'cdtCoId' => $county->id], ['cdtUId' => Auth::user()->id,
                            'cdtBsId' => $request->bsId,
                            'cdtIdNumber' => $request['county' . $county->id] . PublicSetting::getProvincePlanLebel() . $request->code,
                            'cdtSubject' => PublicSetting::checkPersianCharacters($request->subject),
                            'cdtDescription' => isset($request['countyDesc' . $county->id]) ? PublicSetting::checkPersianCharacters($request['countyDesc' . $county->id]) : '',
                            'cdtCoId' => $county->id,
                            'cdtCdtId' => $cdpt->id]);
                        SystemLog::setBudgetSubSystemAdminLog('تغییر عنوان طرح توزیع اعتبار در سطح شهرستان ' . $county->coName);
                    } else if ($cdtP->where('cdtCoId', $county->id)->exists()) {
                        try {
                            $cdtP->where('cdtCoId', $county->id)->delete();
                            SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار ' . $county->coName);
                        } catch (\Illuminate\Database\QueryException $e) {
                        }
                    }
                }
                SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان طرح توزیع اعتبار (' . $old->cdtSubject . ') به (' . $cdpt->cdtSubject . ')');
                return \response()->json($this->getAllPlanOrCostTitle($request->searchValue, $request->itemInPage));
            }
        });
        return $result;
    }

    public function deletePlanTitle(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            try {
                $logTemp = CreditDistributionTitle::find($request->id);
                CreditDistributionTitle::where('cdtCdtId', '=', $request->id)->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار در سطح شهرستان با عنوان ' . $logTemp->cdptSubject);

                $cdpt = CreditDistributionTitle::find($request->id);
                $cdpt->delete();
                SystemLog::setBudgetSubSystemAdminLog('حذف عنوان طرح توزیع اعتبار ' . $logTemp->cdptSubject);
                return \response()->json($this->getAllPlanOrCostTitle($request->searchValue, $request->itemInPage));
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
    }

    public function getAllPlanOrCostTitle($searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return CreditDistributionTitle::where('cdtCoId' , '=' , null)
            ->where(function($q) use($searchValue){
                $q->where('cdtIdNumber' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cdtSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cdtDescription' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->with('budgetSeason')
            ->with('CDTInCounty')
            ->with('CDTInCounty.county')
            ->orderBy('id', 'DESC')
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

