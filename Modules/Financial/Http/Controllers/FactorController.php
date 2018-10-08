<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\Factor;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RefundCosts;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
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
            $factor->fDescription = PublicSetting::checkPersianCharacters($request->description);
            $factor->save();

            if ($request->refundCostsId)
            {
                $refundCost = new RefundCosts();
                $refundCost->rcFId = $factor->id;
                $refundCost->rcRId = $request->refundCostsId;
                $refundCost->save();
            }

            SystemLog::setFinancialSubSystemLog('ثبت فاکتور ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function accept(Request $request)
    {
        DB::transaction(function () use($request){
            Factor::where('fRId' , '=' , $request->rId)
                ->update(['fIsAccepted' => true]);

            $req = _Request::find($request->rId);
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
            SystemLog::setFinancialSubSystemLog('تایید فاکتور های درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function delete(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $factor = Factor::where('id' , '=' , $request->fId)->first();
            if ($factor->fIsAccepted == false)
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
