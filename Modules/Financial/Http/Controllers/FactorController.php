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
use Modules\Financial\Entities\CostFinancing;
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

    function accept(Request $request)
    {
        DB::transaction(function () use($request){
            $req = _Request::find($request->rId);

            if ($req->isFromRefundCosts == true)
            {
                Factor::where('fRId' , '=' , $request->rId)
                    ->update(['fFsId' => FactorState::where('fsState' , 'PENDING_REVIEW')->value('id')]);
                $req->rRsId = RequestState::where('rsState' , '=' , 'WAITING_REVIEW')->value('id');
                $req->save();

                // make history for this request
                $history = new RequestHistory();
                $history->rhSrcUId = Auth::user()->id;
                $history->rhDestUId = Auth::user()->id; // for secretariat destination
                $history->rhRId = $req->id;
                $history->rhRsId = $req->rRsId;
                $history->rhDescription = 'فاکتور های خرید ثبت شده و برای بررسی و تایید به امور مالی ارائه گردید.';
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

            $costFinancing = CostFinancing::where('cfRId' , $factor->fRId)->get()->sortBy('cfRemainingAmount');
            $capFinancing = CapitalAssetsFinancing::where('cafRId' , $factor->fRId)->get()->sortBy('cafRemainingAmount');
            $financingCount = count($costFinancing) + count($capFinancing);

            $pieceOfAmount = round($factor->fAmount / $financingCount);
            $remainingAmount = $factor->fAmount - ($pieceOfAmount * $financingCount);

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

                $draftIds = Draft::where('dRId' , $factor->fRId)->pluck('id');
                $checks = _Check::whereId('cDId' , $draftIds)->get();
                foreach ($checks as $check)
                {
                    //if ()
                    $costSpent = new CostSpent();
                    $costSpent->csCfId = $cf->id;
                    $costSpent->csCId = $check->id;
                    $costSpent->csAmount = $tempAmount;
                    $costSpent->save();
                }
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
        });

        $rController = new RefundController();
        return \response()->json($rController->getAllRefundData() , $result);
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
