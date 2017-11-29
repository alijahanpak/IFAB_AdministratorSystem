<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CostAllocation;

class BudgetController extends Controller
{
    public function getAllStatisticsData()
    {
        $approvedPlanExchangedCount = CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 0)->count();

        $sumOfCapAllocation = CapitalAssetsAllocation::with('creditSource.capitalAssetsProject.capitalAssetsApprovedPlan')
            ->whereHas('creditSource.capitalAssetsProject.capitalAssetsApprovedPlan' , function($query){
                return $query->where('capFyId' , '=' , Auth::user()->seFiscalYear);
            })->sum('caaAmount');

        $sumOfCaAllocation = CostAllocation::with('creditSource.costAgreement')
            ->whereHas('creditSource.costAgreement' , function($query){
                return $query->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            })->sum('caAmount');
        return \response()->json([
            'approvedPlanExchangedCount' => $approvedPlanExchangedCount,
            'sumOfCapAllocation' => $sumOfCapAllocation,
            'sumOfCaAllocation' => $sumOfCaAllocation,
        ]);
    }
}
