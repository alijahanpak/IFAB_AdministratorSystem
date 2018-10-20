<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\CapSpent;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\CostSpent;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\Factor;
use Modules\Financial\Entities\FactorState;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RefundCosts;
use Modules\Financial\Entities\RefundFactor;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\Seller;

class FactorController extends Controller
{
    function addNewFactor(Request $request)
    {
        DB::transaction(function () use($request){
            $sId = Seller::firstOrCreate(['sSubject' => PublicSetting::checkPersianCharacters($request->seller)]);
            $factor = new Factor();
            $factor->fRId = $request->rId;
            $factor->fSId = $sId->id;
            $factor->fSubject = PublicSetting::checkPersianCharacters($request->subject);
            $factor->fAmount = $request->amount;
            $factor->fFsId = FactorState::where('fsState' , 'TEMPORARY')->value('id');
            $factor->fDescription = PublicSetting::checkPersianCharacters($request->description);
            $factor->save();

            if ($request->refundId)
            {
                $refundFactor = new RefundFactor();
                $refundFactor->rfFId = $factor->id;
                $refundFactor->rfRId = $request->refundId;
                $refundFactor->save();
            }

            SystemLog::setFinancialSubSystemLog('ثبت فاکتور ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function addNewRefundFactor(Request $request)
    {
        DB::transaction(function () use($request){
            $sId = Seller::firstOrCreate(['sSubject' => PublicSetting::checkPersianCharacters($request->seller)]);
            $factor = new Factor();
            $factor->fRId = $request->rId;
            $factor->fSId = $sId->id;
            $factor->fSubject = PublicSetting::checkPersianCharacters($request->subject);
            $factor->fAmount = $request->amount;
            $factor->fFsId = FactorState::where('fsState' , 'TEMPORARY')->value('id');
            $factor->fDescription = PublicSetting::checkPersianCharacters($request->description);
            $factor->save();

            SystemLog::setFinancialSubSystemLog('ثبت فاکتور ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllPostedRequests(Auth::user()->id)
        );
    }

    function deleteRefundFactor(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $factor = Factor::where('id' , '=' , $request->fId)->first();
            if ($factor->fFsId == FactorState::where('fsState' , 'TEMPORARY')->value('id'))
            {
                $factor->delete();
                return 200;
            }else{
                return 204; //cannot delete contract
            }
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllPostedRequests(Auth::user()->id),
            $resultCode
        );
    }

    function accept(Request $request)
    {
        DB::transaction(function () use($request){
            $req = _Request::find($request->rId);

            if ($req->isFromRefundCosts == true)
            {
                Factor::where('fRId' , '=' , $request->rId)
                    ->where('fFsId' , FactorState::where('fsState' , 'TEMPORARY')->value('id'))
                    ->update(['fFsId' => FactorState::where('fsState' , 'PENDING_REVIEW')->value('id')]);

                $req->rRsId = RequestState::where('rsState' , '=' , 'WAITING_REVIEW')->value('id');
                $req->save();

                // make history for this request
                $history = new RequestHistory();
                $history->rhSrcUId = Auth::user()->id;
                $history->rhDestUId = Auth::user()->id; // for secretariat destination
                $history->rhRId = $req->id;
                $history->rhRsId = $req->rRsId;
                $history->rhHasBeenSeen = true;
                $history->rhDescription = 'فاکتور ها ثبت شد و برای بررسی و تایید به امور مالی ارائه گردید.';
                $history->save();
            }else{
                Factor::where('fRId' , '=' , $request->rId)
                    ->update(['fFsId' => FactorState::where('fsState' , 'ACCEPTED')->value('id')]);
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                if ($req->rAcceptedAmount != $req->rCommitmentAmount)
                {
                    $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'FINANCIAL')->value('id');

                    RequestHistoryLastPoint::updateOrCreate(['rhlpRId' => $req->id] , [
                        'rhlpRlId' => RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id'),
                        'rhlpRsId' => RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id'),
                        'rhlpPrId' => null,
                        'rhlpDescription' => 'با توجه به تفاوت مجموع مبلغ فاکتور ها با مبلغ تعهد شده، درخواست نیاز به اصلاح تامین اعتبار دارد.'
                    ]);
                }
                else
                    $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id');
                $req->save();

                // make history for this request
                $history = new RequestHistory();
                $history->rhSrcUId = Auth::user()->id;
                $history->rhDestUId = null; // for secretariat destination
                $history->rhRId = $req->id;
                $history->rhRsId = $req->rRsId;
                $history->save();

                $finReqQueue = new FinancialRequestQueue();
                $finReqQueue->frqRId = $req->id;
                $finReqQueue->save();
            }
            SystemLog::setFinancialSubSystemLog('تایید فاکتور های درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function acceptAndCalculate(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $factor = Factor::find($request->fId);
            $factor->fFsId = FactorState::where('fsState' , 'ACCEPTED')->value('id');
            $factor->save();

            $costFinancing = CostFinancing::where('cfRId' , $request->rId)->get()->sortBy('cfRemainingAmount');
            $capFinancing = CapitalAssetsFinancing::where('cafRId' , $request->rId)->get()->sortBy('cafRemainingAmount');
            $financingCount = count($costFinancing) + count($capFinancing);

            $draftIds = Draft::where('dRId' , $request->rId)->pluck('id');
            $checks = _Check::whereIn('cDId' , $draftIds)->get();
            $factorRemainingAmount = $factor->fAmount;
            $remainingAmount = 0;
            foreach ($checks as $check)
            {
                $calcAmount = 0;
                $checkRemainingAmount = $check->cAmount - $check->cSpentAmount;
                if ($checkRemainingAmount >= $factorRemainingAmount)
                {
                    $calcAmount = $factorRemainingAmount;
                }else{
                    $calcAmount = $factorRemainingAmount - $checkRemainingAmount;
                }
                $factorRemainingAmount -= $calcAmount;

                $pieceOfAmount = round($calcAmount / $financingCount);
                $remainingAmount = $calcAmount - ($pieceOfAmount * $financingCount);

                foreach ($costFinancing as $cf)
                {
                    if ($cf->cfRemainingAmount >= ($pieceOfAmount + $remainingAmount))
                    {
                        $tempAmount = $pieceOfAmount + $remainingAmount;
                        $remainingAmount = 0;
                    }else if ($cf->cfRemainingAmount >= $pieceOfAmount){
                        $tempAmount = $pieceOfAmount;
                    }else{
                        $tempAmount = $cf->cfRemainingAmount;
                        $remainingAmount += $pieceOfAmount - $cf->cfRemainingAmount;
                    }

                    $costSpent = new CostSpent();
                    $costSpent->csCfId = $cf->id;
                    $costSpent->csCId = $check->id;
                    $costSpent->csAmount = $tempAmount;
                    $costSpent->save();
                }


                foreach ($capFinancing as $caf)
                {
                    if ($caf->cafRemainingAmount >= ($pieceOfAmount + $remainingAmount))
                    {
                        $tempAmount = $pieceOfAmount + $remainingAmount;
                        $remainingAmount = 0;
                    }else if ($caf->cafRemainingAmount >= $pieceOfAmount){
                        $tempAmount = $pieceOfAmount;
                    }else{
                        $tempAmount = $caf->cafRemainingAmount;
                        $remainingAmount += $pieceOfAmount - $caf->cafRemainingAmount;
                    }

                    $capSpent = new CapSpent();
                    $capSpent->csCafId = $caf->id;
                    $capSpent->csCId = $check->id;
                    $capSpent->csAmount = $tempAmount;
                    $capSpent->save();
                }

                if ($factorRemainingAmount == 0)
                    break;
            }

            if ($remainingAmount != 0)
                return 500;
            else{
                SystemLog::setFinancialSubSystemLog('تایید فاکتور کارپردازی با عنوان ' .  $factor->fSubject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
                return 200;
            }
        });

        $rController = new RefundController();
        return \response()->json($rController->getAllRefundData() , $result);
    }

    function reject(Request $request)
    {
        DB::transaction(function () use($request) {
            $factor = Factor::find($request->fId);
            $factor->fFsId = FactorState::where('fsState', 'NOT_ACCEPTED')->value('id');
            $factor->save();

            $req = _Request::find($factor->fRId);
            if ($req->rRtId == RequestType::where('rtType' , 'BUY_COMMODITY')->value('id'))
            {
                $reqHis = RequestHistory::find(RequestHistory::where('rhRId' , '=' , $req->id)->max('id'));
                $reqHis->rhHasBeenSeen = false;
                $reqHis->save();
            }
        });

        $rController = new RefundController();
        return \response()->json($rController->getAllRefundData());
    }

    function delete(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $factor = Factor::where('id' , '=' , $request->fId)->first();
            if ($factor->fFsId == FactorState::where('fsState' , 'TEMPORARY')->value('id'))
            {
                $factor->delete();
                return 200;
            }else{
                return 204; //cannot delete contract
            }
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
            , $resultCode);
    }
}
