<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsCost;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CdrCaa;
use Modules\Budget\Entities\CostAgreement;
use Modules\Budget\Entities\CostAllocation;
use Modules\Budget\Entities\CreditDistributionRow;
use Morilog\Jalali\Facades\jDate;

class AllocationOfCapitalAssetsController extends Controller
{
    public function fetchAllocation(Request $request)
    {
        return \response()->json(
            $this->getAllCapitalAssetsAllocates($request->pOrN)
        );
    }

    public function getAllCapitalAssetsAllocates($pOrN)
    {
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->has('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.Allocation')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.Allocation')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.creditDistributionRow')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.tinySeason.seasonTitle.season')
            ->with('capitalAssetsProjectHasCreditSource.creditSourceHasAllocation.howToRun')
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->paginate(5);
    }

    public function getAllCapitalAssetsFound()
    {
        return CapitalAssetsAllocation::where('caaFound' , '=' , true)
            ->where('caaFyId' , '=' , Auth::user()->seFiscalYear)
            ->get();
    }

    public function registerCapitalAssetsAllocation(Request $request)
    {
        $alloc = new CapitalAssetsAllocation;
        $alloc->caaUId = Auth::user()->id;
        $alloc->caaCcsId = $request->pcsId;
        $alloc->caaLetterNumber = $request->idNumber;
        $alloc->caaLetterDate = $request->date;
        $alloc->caaDescription = $request->description;
        $alloc->caaAmount = AmountUnit::convertInputAmount($request->amount);
        $alloc->save();

        SystemLog::setBudgetSubSystemLog('ثبت تخصیص اعتبار تملک داریی های سرمایه ای');
        return \response()->json(
            $this->getAllCapitalAssetsAllocates($request->pOrN)
        );
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
        $alloc = new CapitalAssetsAllocation;
        $alloc->caaUId = Auth::user()->id;
        $alloc->caaFyId = Auth::user()->seFiscalYear;
        $alloc->caaFound = true;
        $alloc->caaLetterDate = $request->date;
        $alloc->caaDescription = $request->description;
        $alloc->caaAmount = AmountUnit::convertInputAmount($request->amount);
        $alloc->save();

        SystemLog::setBudgetSubSystemLog('ثبت تنخواه تملک داریی های سرمایه ای');
        return \response()->json(
            $this->getAllCapitalAssetsFound()
        );
    }

    public function getAllCapitalAssetsCosts(Request $request) // for test convert found to allocation
    {
        return \response()->json(
            CapitalAssetsCost::where('cacCaaId' , '=' , $request->fId)->get()
        );
    }

    public function convertCapitalAssetsFoundToAllocation(Request $request)
    {
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
        $alloc->caaDescription = $request->description;
        $alloc->caaAmount = $sumOfCost;
        $alloc->caaFoundId = $request->id;
        $alloc->save();

        CapitalAssetsCost::whereIn('id' , $costsId)->update(['cacCaaId' => $alloc->id]);
        return \response()->json([
            'found' => $this->getAllCapitalAssetsFound(),
            'allocation_prov' => $this->getAllCapitalAssetsAllocates(0)
        ]);
    }

    ////////////////////////// cost ////////////////////////////////
    public function registerCostAllocation(Request $request)
    {
        $caAlloc = new CostAllocation;
        $caAlloc->caUId = Auth::user()->id;
        $caAlloc->caCcsId = $request->ccsId;
        $caAlloc->caLetterNumber = $request->idNumber;
        $caAlloc->caLetterDate = $request->date;
        $caAlloc->caAmount = AmountUnit::convertInputAmount($request->amount);
        $caAlloc->caDescription = $request->description;
        $caAlloc->save();

        SystemLog::setBudgetSubSystemLog('ثبت تخصیص اعتبار هزینه ای');
        return \response()->json(
            $this->getAllCostAllocates($request->pOrN)
        );
    }

    public function getAllCostAllocates($pOrN)
    {
        return CostAgreement::where('caFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('caProvinceOrNational' , '=' , $pOrN)
            ->has('caCreditSourceHasAllocation')
            ->with('caCreditSourceHasAllocation.allocation')
            ->with('caCreditSourceHasAllocation.creditDistributionRow')
            ->with('caCreditSourceHasAllocation.tinySeason.seasonTitle.season')
            ->with('caCreditSourceHasAllocation.creditDistributionTitle')
            ->with('caCreditSourceHasAllocation.creditDistributionTitle.county')
            ->paginate(5);
    }

    public function fetchCostAllocationData(Request $request)
    {
        return \response()->json(
            $this->getAllCostAllocates($request->pOrN)
        );
    }
}
