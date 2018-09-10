<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\AmountUnit;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CostAllocation;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RefundCosts;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\SupplierRequestQueue;
use Modules\Financial\Entities\UnitOfContractRequestQueue;

class FinanceController extends Controller
{
    private function getAllCostFinancingByRId($rId)
    {
        return CostFinancing::where('cfRId' , '=' , $rId)
            ->with('allocation.creditSource.tinySeason.seasonTitle.season')
            ->with('allocation.creditSource.costAgreement')
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
            DB::transaction(function () use($request){
                $insertedAId = array();
                $i = 0;
                foreach ($request->costFinancing as $costFinanc)
                {
                    $costAllocInfo = CostAllocation::where('id' , '=' , $costFinanc['aId'])->first();
                    $lastReserve = CostFinancing::where('cfCaId' , '=' , $costFinanc['aId'])
                        ->where('cfRId' ,'=', $request->rId)
                        ->value('cfAmount');

                    $remainigAmount = $costAllocInfo['caAmount'] - ($costAllocInfo['caSumOfCost'] + (($costAllocInfo['caSumOfReserved'] + $costAllocInfo['caSumOfFinancing']) - $lastReserve));
                    if (($remainigAmount - $costFinanc['amount']) >= 0)
                    {
                        CostFinancing::updateOrCreate(['cfCaId' => $costFinanc['aId'] , 'cfRId' => $request->rId],
                            ['cfAmount' => $costFinanc['amount'] , 'cfAccepted' => false]);
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
            });
        }

        if (is_array($request->capFinancing))
        {
            DB::transaction(function () use($request){
                $insertedAId = array();
                $i = 0;
                foreach ($request->capFinancing as $capFinanc)
                {
                    $capAllocInfo = CapitalAssetsAllocation::where('id' , '=' , $capFinanc['aId'])->first();
                    $lastReserve = CapitalAssetsFinancing::where('cafCaaId' , '=' , $capFinanc['aId'])
                        ->where('cafRId' ,'=', $request->rId)
                        ->value('cafAmount');
                    $remainigAmount = $capAllocInfo['caaAmount'] - ($capAllocInfo['caaSumOfCost'] + (($capAllocInfo['caaSumOfReserved'] + $capAllocInfo['caaSumOfFinancing']) - $lastReserve));
                    if (($remainigAmount - $capFinanc['amount']) >= 0)
                    {
                        CapitalAssetsFinancing::updateOrCreate(['cafCaaId' => $capFinanc['aId'] , 'cafRId' => $request->rId],
                            ['cafAmount' => $capFinanc['amount'] , 'cafAccepted' => false]);
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
            });
        }

        return \response()->json($this->getAllFinancing($request->rId));
    }

    public function deleteCostFinancing(Request $request)
    {

    }

    public function deleteCapFinancing(Request $request)
    {

    }

    public function acceptFinancing(Request $request)
    {
        DB::transaction(function () use($request){
            CostFinancing::where('cfRId' , '=' , $request->rId)
                ->update(['cfAccepted' => true]);

            CapitalAssetsFinancing::where('cafRId' , '=' , $request->rId)
                ->update(['cafAccepted' => true]);

            $req = _Request::where('id' , '=' , $request->rId)->with('requestType')->first();
            if ($req->requestType->rtType == 'BUY_COMMODITY')
            {
                $req = _Request::find($request->rId);
                $req->rRsId = RequestState::where('rsState' , '=' , 'SUPPLIER_QUEUE')->value('id');
                $req->save();

                $supReqQueue = new SupplierRequestQueue();
                $supReqQueue->srqRId = $req->id;
                $supReqQueue->save();
            }else if ($req->requestType->rtType == 'BUY_SERVICES'){
                $req = _Request::find($request->rId);
                $req->rRsId = RequestState::where('rsState' , '=' , 'UNIT_OF_CONTRACT_QUEUE')->value('id');
                $req->save();

                $ufcReqQueue = new UnitOfContractRequestQueue();
                $ufcReqQueue->ufcrqRId = $req->id;
                $ufcReqQueue->save();
            }else if ($req->requestType->rtType == 'FUND'){
                $req = _Request::find($request->rId);
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                $req->save();

                $finReqQueue = new FinancialRequestQueue();
                $finReqQueue->frqRId = $req->id;
                $finReqQueue->save();
            }

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for financial destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhDescription = 'تامین اعتبار، مورد تایید می باشد.';
            $history->save();

        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function supplyFromRefund(Request $request)
    {
        DB::transaction(function () use($request){
            $req = _Request::find($request->id);
            $req->isFromRefundCosts = true;
            $req->rRsId = RequestState::where('rsState' , '=' , 'SUPPLIER_QUEUE')->value('id');
            $req->save();

            $supReqQueue = new SupplierRequestQueue();
            $supReqQueue->srqRId = $req->id;
            $supReqQueue->save();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for supplier destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhDescription = 'با سلام، لطفا از محل تنخواه گردان تدارکات تامین گردد.';
            $history->save();
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }
}
