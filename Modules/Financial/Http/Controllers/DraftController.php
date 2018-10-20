<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\AccountantRequestQueue;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\DraftState;
use Modules\Financial\Entities\DraftVerifier;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\IncreaseDraftAmount;
use Modules\Financial\Entities\PercentageDecrease;
use Modules\Financial\Entities\PercentageIncrease;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\SecretariatRequestQueue;

class DraftController extends Controller
{
    function register(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $req = _Request::where('id' , '=' , $request->rId)->first();
            $draft = new Draft();
            $draft->dRId = $request->rId;
            $draft->dDsId = DraftState::where('dsState' , '=' , 'MINUTE')->value('id');
            $draft->dFor = PublicSetting::checkPersianCharacters($request->for);
            $draft->dPayTo = PublicSetting::checkPersianCharacters($request->payTo);
            if (isset($request->prId))
                $draft->dPrId = $request->prId;
            $draft->dBaseAmount = $request->baseAmount;
            $draft->dAmount = $request->amount;
            $draft->dSumOfLastDraftAmount = $req->rSumOfDraftAmount;
            $draft->save();

            $verifier = new DraftVerifier();
            $verifier->dvUId = $request->verifierId;
            $verifier->dvDId = $draft->id;
            $verifier->save();
            ///////////////////////////////////////////////////////////////////////
            $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
            $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id');
            $req->save();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for secretariat destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhDId = $draft->id;
            $history->save();

            $finReqQueue = new FinancialRequestQueue();
            $finReqQueue->frqRId = $req->id;
            $finReqQueue->save();


            SystemLog::setFinancialSubSystemLog('ثبت حواله برای درخواست ' . $req->rSubject);

            return 200;
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        ,$resultCode);
    }

    function acceptMinute(Request $request)
    {
        DB::transaction(function () use($request){
                $verifier = DraftVerifier::where('dvDId' , '=' , $request->dId)->first();

                $req = _Request::where('id' , '=' , $request->rId)->first();
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id');
                $req->save();

                $draft = Draft::find($request->dId);
                $draft->dDsId = DraftState::where('dsState' , '=' , 'NEW')->value('id');
                $draft->dIsMinute = false;
                $draft->save();
                // make history for this request
                $history = new RequestHistory();
                $history->rhSrcUId = Auth::user()->id;
                $history->rhDestUId = $verifier->dvUId;
                $history->rhRId = $req->id;
                $history->rhRsId = $req->rRsId;
                $history->rhDId = $draft->id;
                $history->save();

                SystemLog::setFinancialSubSystemLog('تایید پیشنویس حواله پرداخت برای درخواست ' . $req->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function accept(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $sig = Signature::where('sUId' , '=' , Auth::user()->id)->first();

            if (DraftVerifier::where('dvDId' , '=' , $request->dId)
                ->where('dvUId' , '=' , Auth::user()->id)
                ->exists())
            {
                DraftVerifier::where('dvDId' , '=' , $request->dId)
                    ->update(['dvSId' => $sig->id]);

                $req = _Request::where('id' , '=' , $request->rId)->first();
                $req->rRsId = RequestState::where('rsState' , '=' , 'SECRETARIAT_QUEUE')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id');
                $req->save();

                $draft = Draft::find($request->dId);
                $draft->dDsId = DraftState::where('dsState' , '=' , 'ACCEPTED')->value('id');
                $draft->save();
                // make history for this request
                $history = new RequestHistory();
                $history->rhSrcUId = Auth::user()->id;
                $history->rhDestUId = null; // for secretariat destination
                $history->rhRId = $req->id;
                $history->rhRsId = $req->rRsId;
                $history->rhDId = $draft->id;
                $history->save();

                $srQueue = new SecretariatRequestQueue();
                $srQueue->srqRId = $req->id;
                $srQueue->save();

                SystemLog::setFinancialSubSystemLog('تایید حواله پرداخت برای درخواست ' . $req->rSubject);
                return 200;
            }else
                return 500;
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
            ,$resultCode);
    }

    public function numbering(Request $request)
    {
        DB::transaction(function () use($request){
            $draft = Draft::find($request->dId);
            $draft->dLetterNumber = $request->letterNumber;
            $draft->dLetterDate = $request->letterDate;
            $draft->save();

            $req = _Request::find($request->rId);
            $req->rRsId = RequestState::where('rsState' , '=' , 'ACCOUNTANT_QUEUE')->value('id');
            $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'DRAFT')->value('id');
            $req->save();

            SecretariatRequestQueue::where('srqRId' , '=' , $req->id)->delete();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhDId = $draft->id;
            $history->save();

            $accReqQueue = new AccountantRequestQueue();
            $accReqQueue->arqRId = $req->id;
            $accReqQueue->save();

            SystemLog::setFinancialSubSystemLog('شماره گذاری حواله برای درخواست ' . $req->rSubject . ' در دبیرخانه');
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    public function getPercentageDecrease()
    {
        return \response()->json(
            PercentageDecrease::where('pdState' , '=' , true)->get()
        );
    }

    public function wasSeen(Request $request)
    {
        $rHistory = RequestHistory::find($request->rhId);
        $rHistory->rhDHasBeenSeen = true;
        $rHistory->save();

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    public function block(Request $request)
    {
        DB::transaction(function () use($request){
            $draft = Draft::find($request->dId);
            $draft->dDsId = DraftState::where('dsState' , '=' , 'BLOCKED')->value('id');
            $draft->save();

            $req = _Request::find($draft->dRId);
            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = Auth::user()->id; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhDId = $draft->id;
            $history->rhDHasBeenSeen = true;
            $history->rhHasBeenSeen = true;
            $history->rhDescription = PublicSetting::checkPersianCharacters($request->description) . ' (حواله: ' . $draft->dFor . ')';
            $history->save();

            SystemLog::setFinancialSubSystemLog('مسدود کردن حواله با عنوان ' . $draft->dFor);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }
}
