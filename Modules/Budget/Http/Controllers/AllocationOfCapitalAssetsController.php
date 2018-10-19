<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsCost;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CdrCaa;
use Modules\Budget\Entities\CostAgreement;
use Modules\Budget\Entities\CostAllocation;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\ExpenseCosts;
use Morilog\Jalali\Facades\jDate;

class AllocationOfCapitalAssetsController extends Controller
{
    public function fetchAllocation(Request $request)
    {
        return \response()->json(
            $this->getAllCapitalAssetsAllocates($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function getAllCapitalAssetsAllocates($pOrN , $searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->has('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.Allocation')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.Allocation')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.creditDistributionRow')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.tinySeason.seasonTitle.season')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.howToRun')
            ->with('creditDistributionTitle')
            ->whereHas('creditDistributionTitle' , function ($query) use($searchValue){
                return $query->where('cdtIdNumber' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cdtSubject' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->with('creditDistributionTitle.county')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function getAllCapitalAssetsFound()
    {
        return CapitalAssetsAllocation::where('caaFound' , '=' , true)
            ->where('caaFyId' , '=' , Auth::user()->seFiscalYear)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function registerCapitalAssetsAllocation(Request $request)
    {
        DB::transaction(function () use($request){
            $alloc = new CapitalAssetsAllocation;
            $alloc->caaUId = Auth::user()->id;
            $alloc->caaCcsId = $request->pcsId;
            $alloc->caaLetterNumber = $request->idNumber;
            $alloc->caaLetterDate = $request->date;
            $alloc->caaDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caaAmount = AmountUnit::convertInputAmount($request->amount);
            $alloc->save();

            SystemLog::setBudgetSubSystemLog('ثبت تخصیص اعتبار تملک داریی های سرمایه ای');
        });

        return \response()->json(
            $this->getAllCapitalAssetsAllocates($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function updateCapitalAssetsAllocation(Request $request)
    {
        DB::transaction(function () use($request){
            $alloc = CapitalAssetsAllocation::find($request->id);
            $alloc->caaUId = Auth::user()->id;
            $alloc->caaCcsId = $request->pcsId;
            $alloc->caaLetterNumber = $request->idNumber;
            $alloc->caaLetterDate = $request->date;
            $alloc->caaDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caaAmount = AmountUnit::convertInputAmount($request->amount);
            $alloc->save();

            SystemLog::setBudgetSubSystemLog('تغییر تخصیص اعتبار تملک داریی های سرمایه ای');
        });

        return \response()->json(
            $this->getAllCapitalAssetsAllocates($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function deleteCapitalAssetsAllocation(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $caa = CapitalAssetsAllocation::find($request->id);
            try {
                $caa->delete();
                SystemLog::setBudgetSubSystemLog('حذف تخصیص اعتبار تملک داریی های سرمایه ای');
                return \response()->json($this->getAllCapitalAssetsAllocates($request->pOrN , $request->searchValue , $request->itemInPage));
            }
            catch (\Illuminate\Database\QueryException $e) {
                if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                    return \response()->json([] , 204);
                }
            }
        });

        return $result;
    }

    public function getCapitalAssetsCreditSourceInfo(Request $request)
    {
        $info['approvedAmount'] = CapCreditSource::where('id' , '=' , $request->pcsId)->value('ccsAmount');
        $info['sumAllocation'] = CapitalAssetsAllocation::where('caaCcsId' , '=' , $request->pcsId)->sum('caaAmount');
        return \response()->json($info);
    }



    public function fetchFound(Request $request)
    {
        return \response()->json(
            $this->getAllCapitalAssetsFound()
        );
    }

    public function registerCapitalAssetsFound(Request $request)
    {
        DB::transaction(function () use($request){
            $alloc = new CapitalAssetsAllocation;
            $alloc->caaUId = Auth::user()->id;
            $alloc->caaFyId = Auth::user()->seFiscalYear;
            $alloc->caaFound = true;
            $alloc->caaLetterDate = $request->date;
            $alloc->caaDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caaAmount = AmountUnit::convertInputAmount($request->amount);
            $alloc->save();

            SystemLog::setBudgetSubSystemLog('ثبت تنخواه تملک داریی های سرمایه ای');
        });

        return \response()->json(
            $this->getAllCapitalAssetsFound()
        );
    }

    public function updateCapitalAssetsFound(Request $request)
    {
        DB::transaction(function () use($request) {
            $alloc = CapitalAssetsAllocation::find($request->id);
            $alloc->caaUId = Auth::user()->id;
            $alloc->caaLetterDate = $request->date;
            $alloc->caaDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caaAmount = AmountUnit::convertInputAmount($request->amount);
            $alloc->save();

            SystemLog::setBudgetSubSystemLog('تغییر تنخواه تملک داریی های سرمایه ای');
        });

        return \response()->json(
            $this->getAllCapitalAssetsFound()
        );
    }

    public function deleteCapitalAssetsFound(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (CapitalAssetsAllocation::where('caaFoundId' , '=' , $request->id)->exists())
            {
                return \response()->json([] , 204);
            }else{
                try {
                    CapitalAssetsAllocation::where('id' , '=' , $request->id)->delete();
                    SystemLog::setBudgetSubSystemLog('حذف تنخواه تملک داریی های سرمایه ای');
                    return \response()->json(
                        $this->getAllCapitalAssetsFound()
                    );
                }
                catch (\Illuminate\Database\QueryException $e) {
                    if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                        return \response()->json([] , 204);
                    }
                }
            }
        });

        return $result;

    }

    public function getAllCapitalAssetsCosts(Request $request) // for test convert found to allocation
    {
        return \response()->json(
            CapitalAssetsCost::where('cacCaaId' , '=' , $request->fId)->get()
        );
    }

    public function convertCapitalAssetsFoundToAllocation(Request $request)
    {
        DB::transaction(function () use($request){
            $sumOfCost = 0;
            $costsId = array();
            $i = 0;
            foreach ($request['selectedCosts'] as $cost)
            {
                $sumOfCost += $cost['cacAmount'];
                $costsId[$i++] = $cost['id'];
            }

            $alloc = new CapitalAssetsAllocation;
            $alloc->caaUId = Auth::user()->id;
            $alloc->caaCcsId = $request->pcsId;
            $alloc->caaLetterDate = jDate::forge()->format('%Y/%m/%d');
            $alloc->caaDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caaAmount = $sumOfCost;
            $alloc->caaFoundId = $request->id;
            $alloc->save();

            CapitalAssetsCost::whereIn('id' , $costsId)->update(['cacCaaId' => $alloc->id]);
            SystemLog::setBudgetSubSystemLog('تبدیل تنخواه تملک دارایی های سرمایه ای به تخصیص');
        });

        return \response()->json([
            'found' => $this->getAllCapitalAssetsFound(),
            'allocation_prov' => $this->getAllCapitalAssetsAllocates(0 , $request->searchValue , $request->itemInPage)
        ]);
    }

    ////////////////////////// cost ////////////////////////////////
    public function registerCostAllocation(Request $request)
    {
        DB::transaction(function () use($request){
            $caAlloc = new CostAllocation;
            $caAlloc->caUId = Auth::user()->id;
            $caAlloc->caCcsId = $request->caCsId;
            $caAlloc->caLetterNumber = $request->idNumber;
            $caAlloc->caLetterDate = $request->date;
            $caAlloc->caAmount = AmountUnit::convertInputAmount($request->amount);
            $caAlloc->caDescription = PublicSetting::checkPersianCharacters($request->description);
            $caAlloc->save();

            SystemLog::setBudgetSubSystemLog('ثبت تخصیص اعتبار هزینه ای');
        });

        return \response()->json(
            $this->getAllCostAllocates($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function updateCostAllocation(Request $request)
    {
        DB::transaction(function () use($request){
            $caAlloc = CostAllocation::find($request->id);
            $caAlloc->caUId = Auth::user()->id;
            $caAlloc->caCcsId = $request->caCsId;
            $caAlloc->caLetterNumber = $request->idNumber;
            $caAlloc->caLetterDate = $request->date;
            $caAlloc->caAmount = AmountUnit::convertInputAmount($request->amount);
            $caAlloc->caDescription = PublicSetting::checkPersianCharacters($request->description);
            $caAlloc->save();

            SystemLog::setBudgetSubSystemLog('تغییر تخصیص اعتبار هزینه ای');
        });

        return \response()->json(
            $this->getAllCostAllocates($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function deleteCostAllocation(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $ca = CostAllocation::find($request->id);
            try {
                $ca->delete();
                SystemLog::setBudgetSubSystemLog('حذف تخصیص اعتبار هزینه ای');
                return \response()->json($this->getAllCostAllocates($request->pOrN , $request->searchValue , $request->itemInPage));
            }
            catch (\Illuminate\Database\QueryException $e) {
                if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                    return \response()->json([] , 204);
                }
            }
        });
        return $result;

    }

    public function getCostCreditSourceInfo(Request $request)
    {
        $info['approvedAmount'] = CaCreditSource::where('id' , '=' , $request->caCsId)->value('ccsAmount');
        $info['sumAllocation'] = CostAllocation::where('caCcsId' , '=' , $request->caCsId)->sum('caAmount');
        return \response()->json($info);
    }

    public function getAllCostAllocates($pOrN , $searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return CostAgreement::where('caFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('caProvinceOrNational' , '=' , $pOrN)
            ->where(function($query) use($searchValue){
                return $query->where('caLetterNumber' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->has('caCreditSourceHasAllocation')
            ->with('caCreditSourceHasAllocation.allocation')
            ->with('caCreditSourceHasAllocation.creditDistributionRow')
            ->with('caCreditSourceHasAllocation.tinySeason.seasonTitle.season')
            ->with('caCreditSourceHasAllocation.creditDistributionTitle')
            ->with('caCreditSourceHasAllocation.creditDistributionTitle.county')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function fetchCostAllocationData(Request $request)
    {
        return \response()->json(
            $this->getAllCostAllocates($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function fetchCostFound(Request $request)
    {
        return \response()->json(
            $this->getAllCostFound()
        );
    }

    public function getAllExpenseCosts(Request $request) // for test convert found to allocation
    {
        return \response()->json(
            ExpenseCosts::where('ecCaId' , '=' , $request->fId)->get()
        );
    }

    public function getAllCostFound()
    {
        return CostAllocation::where('caFound' , '=' , true)
            ->where('caFyId' , '=' , Auth::user()->seFiscalYear)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function registerCostFound(Request $request)
    {
        DB::transaction(function () use($request){
            $alloc = new CostAllocation;
            $alloc->caUId = Auth::user()->id;
            $alloc->caFyId = Auth::user()->seFiscalYear;
            $alloc->caFound = true;
            $alloc->caLetterDate = $request->date;
            $alloc->caDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caAmount = AmountUnit::convertInputAmount($request->amount);
            $alloc->save();

            SystemLog::setBudgetSubSystemLog('ثبت تنخواه هزینه ای');
        });

        return \response()->json(
            $this->getAllCostFound()
        );
    }

    public function updateCostFound(Request $request)
    {
        DB::transaction(function () use($request){
            $alloc = CostAllocation::find($request->id);
            $alloc->caUId = Auth::user()->id;
            $alloc->caLetterDate = $request->date;
            $alloc->caDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caAmount = AmountUnit::convertInputAmount($request->amount);
            $alloc->save();

            SystemLog::setBudgetSubSystemLog('تغییر تنخواه هزینه ای');
        });

        return \response()->json(
            $this->getAllCostFound()
        );
    }

    public function deleteCostFound(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (CostAllocation::where('caFoundId' , '=' , $request->id)->exists())
            {
                return \response()->json([] , 204);
            }else{
                try {
                    CostAllocation::where('id' , '=' , $request->id)->delete();
                    SystemLog::setBudgetSubSystemLog('حذف تنخواه هزینه ای');
                    return \response()->json(
                        $this->getAllCostFound()
                    );
                }
                catch (\Illuminate\Database\QueryException $e) {
                    if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                        return \response()->json([] , 204);
                    }
                }
            }
        });
        return $result;
    }

    public function convertCostFoundToAllocation(Request $request)
    {
        DB::transaction(function () use($request){
            $sumOfCost = 0;
            $costsId = array();
            $i = 0;
            foreach ($request['selectedCosts'] as $cost)
            {
                $sumOfCost += $cost['ecAmount'];
                $costsId[$i++] = $cost['id'];
            }

            $alloc = new CostAllocation;
            $alloc->caUId = Auth::user()->id;
            $alloc->caCcsId = $request->caCsId;
            $alloc->caLetterDate = jDate::forge()->format('%Y/%m/%d');
            $alloc->caDescription = PublicSetting::checkPersianCharacters($request->description);
            $alloc->caAmount = $sumOfCost;
            $alloc->caFoundId = $request->id;
            $alloc->save();

            ExpenseCosts::whereIn('id' , $costsId)->update(['ecCaId' => $alloc->id]);
            SystemLog::setBudgetSubSystemLog('تبدیل تنخواه هزینه ای به تخصیص');
        });

        return \response()->json([
            'found' => $this->getAllCostFound(),
            'allocation_prov' => $this->getAllCostAllocates(0 , $request->searchValue , $request->itemInPage)
        ]);
    }
}
