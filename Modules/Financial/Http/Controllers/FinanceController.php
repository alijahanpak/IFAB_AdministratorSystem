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
use Modules\Financial\Entities\CapSpent;
use Modules\Financial\Entities\Contract;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\CostSpent;
use Modules\Financial\Entities\Factor;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RefundCosts;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
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
            ->orderBy('cfAccepted')
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
            ->orderBy('cafAccepted')
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

                    $remainingAmount = $costAllocInfo['caAmount'] - ($costAllocInfo['caSumOfCost'] + (($costAllocInfo['caSumOfReserved']) - $lastReserve));
                    if (($remainingAmount - $costFinanc['amount']) >= 0)
                    {
                        if (CostFinancing::where('cfCaId' , $costFinanc['aId'])
                            ->where('cfRId' , $request->rId)
                            ->exists())
                        {
                            CostFinancing::updateOrCreate(['cfCaId' => $costFinanc['aId'] , 'cfRId' => $request->rId],
                                ['cfAmount' => $costFinanc['amount']]);
                        }else{
                            CostFinancing::updateOrCreate(['cfCaId' => $costFinanc['aId'] , 'cfRId' => $request->rId],
                                ['cfAmount' => $costFinanc['amount'] , 'cfAccepted' => false]);
                        }
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
                    $remainingAmount = $capAllocInfo['caaAmount'] - ($capAllocInfo['caaSumOfCost'] + (($capAllocInfo['caaSumOfReserved']) - $lastReserve));
                    if (($remainingAmount - $capFinanc['amount']) >= 0)
                    {
                        if (CapitalAssetsFinancing::where('cafCaaId' , $capFinanc['aId'])
                            ->where('cafRId' , $request->rId)
                            ->exists())
                        {
                            CapitalAssetsFinancing::updateOrCreate(['cafCaaId' => $capFinanc['aId'] , 'cafRId' => $request->rId],
                                ['cafAmount' => $capFinanc['amount']]);
                        }else{
                            CapitalAssetsFinancing::updateOrCreate(['cafCaaId' => $capFinanc['aId'] , 'cafRId' => $request->rId],
                                ['cafAmount' => $capFinanc['amount'] , 'cafAccepted' => false]);
                        }

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

        _Request::where('id' , '=' , $request->rId)
            ->update(['rRlId' => RequestLevel::where('rlLevel' , '=' , 'FINANCIAL')->value('id')]);
        return \response()->json($this->getAllFinancing($request->rId));
    }

    public function deleteCostFinancing(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
/*            $existFund = Contract::where('cRId' , '=' , $request->rId)
                ->exists();
            $existFund = Factor::where('fRId' , '=' , $request->rId)
                ->exists();

            if ($existFund)
            {
                return 204;
            }else{
                CostFinancing::where('id' , '=' , $request->id)
                    ->delete();
                return 200;
            }*/

            CostFinancing::where('id' , '=' , $request->id)
                ->delete();
            return 200;

        });

        return \response()->json($this->getAllFinancing($request->rId) , $resultCode);
    }

    public function updateCostFinancing(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $costFinancing = CostFinancing::find($request->cfId);
            $req = _Request::find($costFinancing->cfRId);
            $costAllocation = CostAllocation::find($costFinancing->cfCaId);
            $minAmountLimiter = CostSpent::where('csCfId' , $costFinancing->id)->get()->sum('csAmount');
            $maxAmountLimiter = $costAllocation->caAmount - ((int)$costAllocation->caSumOfCommitment + (int)$costAllocation->caSumOfReserved) + $costFinancing->cfAmount;
            $currentFinancingAmount = CostFinancing::where('cfRId' , $req->id)->get()->sum('cfAmount');
            $currentFinancingAmount += CapitalAssetsFinancing::where('cafRId' , $req->id)->get()->sum('cafAmount');
            if (($request->amount >= (int)$minAmountLimiter) && ($request->amount <= (int)$maxAmountLimiter))
            {
                if (((int)$currentFinancingAmount - $costFinancing->cfAmount + $request->amount) <= $req->rAcceptedAmount)
                {
                    $costFinancing->cfAmount = $request->amount;
                    $costFinancing->save();
                    return 200;
                }
            }
            return 420;
        });
        return \response()->json($this->getAllFinancing($request->rId) , $resultCode);
    }

    public function deleteCapFinancing(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
/*            $existFund = Contract::where('cRId' , '=' , $request->rId)
                ->exists();
            $existFund = Factor::where('fRId' , '=' , $request->rId)
                ->exists();

            if ($existFund)
            {
                return 204;
            }else{
                CapitalAssetsFinancing::where('id' , '=' , $request->id)
                    ->delete();
                return 200;
            }*/

            CapitalAssetsFinancing::where('id' , '=' , $request->id)
                ->delete();
            return 200;

        });

        return \response()->json($this->getAllFinancing($request->rId) , $resultCode);
    }

    public function updateCapFinancing(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $capFinancing = CapitalAssetsFinancing::find($request->cafId);
            $req = _Request::find($capFinancing->cafRId);
            $capAllocation = CapitalAssetsAllocation::find($capFinancing->cafCaaId);
            $minAmountLimiter = CapSpent::where('csCafId' , $capFinancing->id)->get()->sum('csAmount');
            $maxAmountLimiter = $capAllocation->caaAmount - ((int)$capAllocation->caaSumOfCommitment + (int)$capAllocation->caaSumOfReserved) + $capFinancing->cafAmount;
            $currentFinancingAmount = CostFinancing::where('cfRId' , $req->id)->get()->sum('cfAmount');
            $currentFinancingAmount += CapitalAssetsFinancing::where('cafRId' , $req->id)->get()->sum('cafAmount');
            if (($request->amount >= (int)$minAmountLimiter) && ($request->amount <= (int)$maxAmountLimiter))
            {
                if (((int)$currentFinancingAmount - $capFinancing->cafAmount + $request->amount) <= $req->rAcceptedAmount)
                {
                    $capFinancing->cafAmount = $request->amount;
                    $capFinancing->save();
                    return 200;
                }
            }
            return 420;
        });
        return \response()->json($this->getAllFinancing($request->rId) , $resultCode);
    }

    public function acceptFinancing(Request $request)
    {
        DB::transaction(function () use($request){
            CostFinancing::where('cfRId' , '=' , $request->rId)
                ->update(['cfAccepted' => true]);

            CapitalAssetsFinancing::where('cafRId' , '=' , $request->rId)
                ->update(['cafAccepted' => true]);

            $prId = null;
            $req = _Request::where('id' , '=' , $request->rId)->with('requestType')->first();
            if ($req->requestType->rtType == 'BUY_COMMODITY')
            {
                if ($req->rAcceptedAmount == 0)
                {
                    $req = _Request::find($request->rId);
                    $req->rRsId = RequestState::where('rsState' , '=' , 'SUPPLIER_QUEUE')->value('id');
                    $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PURCHASE_AND_CONTRACT')->value('id');
                    $req->save();

                    $supReqQueue = new SupplierRequestQueue();
                    $supReqQueue->srqRId = $req->id;
                    $supReqQueue->save();
                }else{
                    $rhlp = RequestHistoryLastPoint::where('rhlpRId' , '=' , $req->id)->first();
                    $prId = $rhlp->rhlpPrId;

                    $req = _Request::find($request->rId);
                    $req->rRsId = $rhlp->rhlpRsId;
                    $req->rRlId = $rhlp->rhlpRlId;
                    $req->save();

                    RequestHistoryLastPoint::where('rhlpRId' , '=' , $req->id)->delete();

                    $finReqQueue = new FinancialRequestQueue();
                    $finReqQueue->frqRId = $req->id;
                    $finReqQueue->save();
                }
            }else if ($req->requestType->rtType == 'BUY_SERVICES'){
                if ($req->rAcceptedAmount == 0) {
                    $req = _Request::find($request->rId);
                    $req->rRsId = RequestState::where('rsState', '=', 'UNIT_OF_CONTRACT_QUEUE')->value('id');
                    $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PURCHASE_AND_CONTRACT')->value('id');
                    $req->save();

                    $ufcReqQueue = new UnitOfContractRequestQueue();
                    $ufcReqQueue->ufcrqRId = $req->id;
                    $ufcReqQueue->save();
                }else{
                    $rhlp = RequestHistoryLastPoint::where('rhlpRId' , '=' , $req->id)->first();
                    $prId = $rhlp->rhlpPrId;

                    $req = _Request::find($request->rId);
                    $req->rRsId = $rhlp->rhlpRsId;
                    $req->rRlId = $rhlp->rhlpRlId;
                    $req->save();

                    RequestHistoryLastPoint::where('rhlpRId' , '=' , $req->id)->delete();

                    if ($rhlp->rhlpRsId == RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id'))
                    {
                        $finReqQueue = new FinancialRequestQueue();
                        $finReqQueue->frqRId = $req->id;
                        $finReqQueue->save();
                    }
                }
            }else if ($req->requestType->rtType == 'FUND'){
                $req = _Request::find($request->rId);
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id');
                $req->save();

                $finReqQueue = new FinancialRequestQueue();
                $finReqQueue->frqRId = $req->id;
                $finReqQueue->save();
            }

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null;
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhPrId = $prId;
            $history->rhDescription = 'با سلام، تامین اعتبار، تایید شد. به نحو مقتضی اقدام شود.';
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
            $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PURCHASE_AND_CONTRACT')->value('id');
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
