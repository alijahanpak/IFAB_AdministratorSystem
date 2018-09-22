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
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\DraftVerifier;
use Modules\Financial\Entities\IncreaseDraftAmount;
use Modules\Financial\Entities\PercentageIncrease;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestType;

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
}
