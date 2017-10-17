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
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CdrCaa;
use Modules\Budget\Entities\CreditDistributionRow;

class AllocationOfCapitalAssetsController extends Controller
{
    public function fetchAllocation(Request $request)
    {
        return \response()->json($this->getAllCapitalAssetsAllocates($request->pOrN));
    }

    public function getAllCapitalAssetsAllocates($pOrN)
    {
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->with(['capitalAssetsProject' => function($q) {
                $q->with('creditSource')
                    ->has('creditSource')
                    ->with(['creditSource' => function($q){
                        $q->with('Allocation')
                            ->has('Allocation')
                            ->with('creditDistributionRow')
                            ->with('tinySeason.seasonTitle.season')
                            ->with('howToRun');
                    }]);
            }])
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->paginate(5);

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
}
