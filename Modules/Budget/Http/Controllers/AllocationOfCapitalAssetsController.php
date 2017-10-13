<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CdrCaa;
use Modules\Budget\Entities\CreditDistributionRow;

class AllocationOfCapitalAssetsController extends Controller
{
    public function register_of_credit_allocation_assets(){
        return view('budget::pages.register_of_credit_allocation_assets.main',
            ['pageTitle' => 'ثبت تخصیص اعتبار- تملک دارایی و سرمایه ای',
                'requireJsFile' => 'register_of_credit_allocation_assets']);
    }

    public function FetchAllocation(Request $request)
    {
        return \response()->json($this->getAllAllocates());
    }

    public function getAllAllocates()
    {
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->with('creditDistributionTitle')
            ->with('capitalAssetsProject')
            ->with('capitalAssetsProject.howToRun')
            ->with('capitalAssetsProject.tinySeason')
            ->with('capitalAssetsProject.cdrCp')
            ->with('capitalAssetsProject.cdrCp.creditDistributionRow')
            ->with('capitalAssetsProject.capitalAssetsAllocation')
            ->with('capitalAssetsProject.capitalAssetsAllocation.cdrCaa')->get();
    }

    public function registerCapitalAssetsAllocation(Request $request)
    {
        $aInput = $request['aInput'];
        $alloc = new CapitalAssetsAllocation;
        $alloc->caaUId = Auth::user()->id;
        $alloc->caaCpId = $aInput['rocaaProject'];
        $alloc->caaLetterNumber = $aInput['rocaaNumber'];
        $alloc->caaLetterDate = $aInput['rocaaDate'];
        $alloc->save();

/*        $cdrInput = $request['cdrInput'];
        $cdrs = CreditDistributionRow::where('cdPlanOrCost' , 0)->get(); // for capital_assets
        foreach ($cdrs as $cdr) {
            if (isset($cdrInput['cost' . $cdr->id]))
            {
                $cdrCp = new CdrCaa;
                $cdrCp->ccCaaId = $alloc->id;
                $cdrCp->ccCdrId = $cdr->id;
                $cdrCp->ccAmount = AmountUnit::convertInputAmount($cdrInput['cost' . $cdr->id]);
                $cdrCp->save();
            }
        }*/

        SystemLog::setBudgetSubSystemLog('ثبت تخصیص اعتبار تملک داریی های سرمایه ای');
        return \response()->json(
            $this->getAllAllocates()
        );
    }
}
