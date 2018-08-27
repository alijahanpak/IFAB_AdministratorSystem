<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CostAllocation;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestState;

class FinanceController extends Controller
{
    private function getAllCostFinancingByRId($rId)
    {
        return CostFinancing::where('cfRId' , '=' , $rId)
            ->with('allocation.creditSource.tinySeason.seasonTitle.season')
            ->with('allocation.creditSource.creditDistributionRow')
            ->with('allocation.creditSource.creditDistributionTitle.budgetSeason')
            ->with('allocation.creditSource.creditDistributionTitle.county')
            ->get();
    }

    private function getAllCapFinancingByRId($rId)
    {
        return CapitalAssetsFinancing::where('cafRId' , '=' , $rId)
            ->with('allocation.creditSource.tinySeason.seasonTitle.season')
            ->with('allocation.creditSource.howToRun')
            ->with('allocation.creditSource.creditDistributionRow')
            ->with('allocation.creditSource.capitalAssetsProject.county')
            ->with('allocation.creditSource.capitalAssetsProject.capitalAssetsApprovedPlan')
            ->with('allocation.creditSource.capitalAssetsProject.capitalAssetsApprovedPlan.creditDistributionTitle.county')
            ->get();
    }

    private function getAllFinancing($rId)
    {
        return [
            "costFinancing" => $this->getAllCostFinancingByRId($rId),
            "capFinancing" => $this->getAllCapFinancingByRId($rId)
        ];
    }

    public function fetchAllFinancing(Request $request)
    {
        return \response()->json($this->getAllFinancing($request->rId));
    }

    public function reserveFinancing(Request $request)
    {
        if (is_array($request->costFinancing))
        {
            $insertedAId = array();
            $i = 0;
            foreach ($request->costFinancing as $costFinanc)
            {
                $costAllocInfo = CostAllocation::where('id' , '=' , $costFinanc['aId'])->first();
                $remainigAmount = $costAllocInfo['caAmount'] - ($costAllocInfo['caSumOfCost'] + $costAllocInfo['caSumOfReserved'] + $costAllocInfo['caSumOfFinancing']);
                if (($remainigAmount - AmountUnit::convertInputAmount($costFinanc['amount'])) > 0)
                {
                    CostFinancing::updateOrCreate(['cfCaId' => $costFinanc['aId'] , 'cfRId' => $request->rId],
                        ['cfAmount' => AmountUnit::convertInputAmount($costFinanc['amount']) , 'cfAccepted' => false]);
                }else{
                    CostFinancing::whereIn('cfCaId' , $insertedAId)
                        ->where('cfRId' , '=' , $request->rId)
                        ->delete();
                    return \response()->json($this->getAllFinancing($request->rId) , 420); //error in calc request amount
                }

                $insertedAId[$i++] = $costFinanc['aId'];
            }

            // delete old items that not exist in new list items
            CostFinancing::whereNotIn('cfCaId' , $insertedAId)
                ->where('cfRId' , '=' , $request->rId)
                ->delete();
        }

        if (is_array($request->capFinancing))
        {
            $insertedAId = array();
            $i = 0;
            foreach ($request->capFinancing as $capFinanc)
            {
                $capAllocInfo = CapitalAssetsAllocation::where('id' , '=' , $capFinanc['aId'])->first();
                $remainigAmount = $capAllocInfo['caaAmount'] - ($capAllocInfo['caaSumOfCost'] + $capAllocInfo['caaSumOfReserved'] + $capAllocInfo['caaSumOfFinancing']);
                if (($remainigAmount - AmountUnit::convertInputAmount($capFinanc['amount'])) > 0)
                {
                    CapitalAssetsFinancing::updateOrCreate(['cafCaaId' => $capFinanc['aId'] , 'cafRId' => $request->rId],
                        ['cafAmount' => AmountUnit::convertInputAmount($capFinanc['amount']) , 'cafAccepted' => false]);
                }else{
                    CapitalAssetsFinancing::whereIn('cafCaaId' , $insertedAId)
                        ->where('cafRId' , '=' , $request->rId)
                        ->delete();
                    return \response()->json($this->getAllFinancing($request->rId) , 420); //error in calc request amount
                }

                $insertedAId[$i++] = $capFinanc['aId'];
            }

            // delete old items that not exist in new list items
            CapitalAssetsFinancing::whereNotIn('cafCaaId' , $insertedAId)
                ->where('cafRId' , '=' , $request->rId)
                ->delete();
        }

        return \response()->json($this->getAllFinancing($request->rId));
    }

    public function acceptFinancing(Request $request)
    {
        CostFinancing::where('cfRId' , '=' , $request->rId)
            ->update(['cfAccepted' => true]);

        CapitalAssetsFinancing::where('cafRId' , '=' , $request->rId)
            ->update(['cafAccepted' => true]);

        $req = _Request::find($request->rId);
        $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
        $req->save();

        // make history for this request
        $history = new RequestHistory();
        $history->rhSrcUId = Auth::user()->id;
        $history->rhDestUId = null; // for financial destination
        $history->rhRId = $req->id;
        $history->rhRsId = $req->rRsId;
        $history->rhDescription = 'تامین اعتبار انجام شد.';
        $history->save();

        $finReqQueue = new FinancialRequestQueue();
        $finReqQueue->frqRId = $req->id;
        $finReqQueue->save();

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }
}
