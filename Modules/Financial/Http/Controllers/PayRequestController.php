<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\RoleCategory;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\PayRequest;
use Modules\Financial\Entities\PayRequestState;
use Modules\Financial\Entities\PayRequestSteps;
use Modules\Financial\Entities\PayRequestVerifier;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestState;

class PayRequestController extends Controller
{
    function fetchPayRequestSteps(Request $request)
    {
        $userCat = RoleCategory::where('rcRId' , '=' , Auth::user()->rId)->pluck('rcCId');
        $rType = PayRequestSteps::whereHas('category' , function ($q) use($userCat){
            return $q->whereNotIn('id' , $userCat);
        })->where('prstOrder' , '<>' , 1)
            ->with(['category.roleCategory.role.user' => function($q){
                return $q->where('isActive' , '=' , true);
            }])
            ->orderBy('prstOrder')
            ->get();
        return \response()->json($rType);
    }

    public function register(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $payRequest = new PayRequest();
            $payRequest->prRId = $request->rId;
            $payRequest->prPrsId = PayRequestState::where('prsState' ,'=' , 'ACTIVE')->value('id');
            $payRequest->prCId = $request->cId;
            $payRequest->prPhysicalProgress = $request->physicalProgress;
            $payRequest->prAmountProgress = $request->amountProgress;
            $payRequest->prAmount = $request->amount;
            $payRequest->prIsFinal = $request->isFinal;
            $payRequest->prDescription = $request->description;
            $payRequest->save();

            //////////////////////// set verifiers ////////////////////////////////
            $userSig = Signature::where('sUId' , '=' , Auth::user()->id)->first();
            if ($userSig == null)
                return 500;

            $userCat = RoleCategory::where('rcRId' , '=' , Auth::user()->rId)->pluck('rcCId');
            $mySteps = PayRequestSteps::whereIn('prstCId' , $userCat)
                ->orderBy('prstOrder')
                ->get();

            $firstStepId = PayRequestSteps::orderBy('prstOrder')
                ->first();

            PayRequestVerifier::firstOrCreate(['prvSId' => $userSig->id , 'prvPrstId' => $firstStepId->id , 'prvPrId' => $payRequest->id , 'prvUId' => Auth::user()->id]);
            foreach ($mySteps as $myStep)
            {
                PayRequestVerifier::firstOrCreate(['prvSId' => $userSig->id , 'prvPrstId' => $myStep->id , 'prvPrId' => $payRequest->id , 'prvUId' => Auth::user()->id]);
            }

            if (is_array($request->get('verifiers'))) {
                foreach ($request->get('verifiers') as $verifiers){
                    PayRequestVerifier::firstOrCreate(['prvPrstId' => $verifiers['prstId'], 'prvPrId' => $payRequest->id, 'prvUId' => $verifiers['uId']]);
                }
            }
            ///////////////////////////////////////////////////////////////////////
            $req = _Request::find($request->rId);
            $req->rRsId = RequestState::where('rsState' , '=' , 'ACTIVE')->value('id');
            $req->save();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = $request->get('verifiers')[0]['uId'];
            $history->rhRId = $request->rId;
            $history->rhRsId = $req->rRsId;
            $history->save();

            SystemLog::setFinancialSubSystemLog('ثبت درخواست پرداخت برای درخواست ' . $req->rSubject);
            return 200;

        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllPostedRequests(Auth::user()->id) ,
            $result
        );
    }
}
