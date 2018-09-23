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
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\AccountantRequestQueue;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\DraftVerifier;
use Modules\Financial\Entities\IncreaseDraftAmount;
use Modules\Financial\Entities\PercentageIncrease;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\SecretariatRequestQueue;

class DraftController extends Controller
{
    function register(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $draft = new Draft();
            $draft->dRId = $request->rId;
            $draft->dFor = PublicSetting::checkPersianCharacters($request->for);
            $draft->dPayTo = PublicSetting::checkPersianCharacters($request->payTo);
            $draft->dBaseAmount = $request->baseAmount;
            $draft->dAmount = $request->amount;
            $draft->save();

            $verifier = new DraftVerifier();
            $verifier->dvUId = $request->verifierId;
            $verifier->dvDId = $draft->id;
            $verifier->save();
            ///////////////////////////////////////////////////////////////////////
            $reg = _Request::where('id' , '=' , $request->rId)->first();
            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = $request->verifierId;
            $history->rhRId = $request->rId;
            $history->rhRsId = $reg->rRsId;
            $history->save();

            SystemLog::setFinancialSubSystemLog('ثبت حواله برای درخواست ' . $reg->rSubject);

            return 200;
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        ,$resultCode);
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
                $req->save();
                // make history for this request
                $history = new RequestHistory();
                $history->rhSrcUId = Auth::user()->id;
                $history->rhDestUId = null; // for secretariat destination
                $history->rhRId = $req->id;
                $history->rhRsId = $req->rRsId;
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
            $req->save();

            SecretariatRequestQueue::where('srqRId' , '=' , $req->id)->delete();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
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
}
