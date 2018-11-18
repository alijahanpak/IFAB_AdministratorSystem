<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\RoleCategory;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\AccountantRequestQueue;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\PayRequest;
use Modules\Financial\Entities\PayRequestState;
use Modules\Financial\Entities\PayRequestSteps;
use Modules\Financial\Entities\PayRequestVerifier;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\SecretariatRequestQueue;

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
                throw new \Exception(500);

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
            $history->rhPrId = $payRequest->id;
            $history->save();

            SystemLog::setFinancialSubSystemLog('ثبت درخواست پرداخت برای درخواست ' . $req->rSubject);
            $rController = new RequestController();
            return \response()->json($rController->getAllPostedRequests(Auth::user()->id , $request->searchValue));

        });
        return $result;
    }
    public function accept(Request $request)
    {
        $sig = Signature::where('sUId' , '=' , Auth::user()->id)->first();
        $currentVerifier = PayRequestVerifier::find($request->prvId);
        $payReq = PayRequest::find($currentVerifier->prvPrId);

        if ($currentVerifier->prvUId == Auth::user()->id)
        {
            if (count($payReq->prRemainingVerifiers) == 0)
            {
                $result = DB::transaction(function () use($request , $currentVerifier , $sig , $payReq){

                    PayRequestVerifier::where('prvPrId' , '=' , $currentVerifier->prvPrId)
                        ->where('prvUId' , '=' , $currentVerifier->prvUId)
                        ->update(['prvSId' => $sig->id]);

                    $nextVerifier = PayRequestVerifier::where('prvPrId' , '=' , $currentVerifier->prvPrId)
                        ->where('id' , '>' , $currentVerifier->id)
                        ->where('prvSId' , '=' , null)
                        ->first();

                    $req = _Request::find($request->rId);
                    $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PAYMENT')->value('id');
                    $req->save();
                    if ($nextVerifier)
                    {
                        // make history for this request
                        $history = new RequestHistory();
                        $history->rhSrcUId = Auth::user()->id;
                        $history->rhDestUId = $nextVerifier->prvUId;
                        $history->rhRId = $req->id;
                        $history->rhRsId = $req->rRsId;
                        $history->rhPrId = $currentVerifier->prvPrId;
                        $history->save();
                    }else{
                        $req->rRsId = RequestState::where('rsState' , '=' , 'SECRETARIAT_QUEUE')->value('id');
                        $req->save();
                        // make history for this request
                        $history = new RequestHistory();
                        $history->rhSrcUId = Auth::user()->id;
                        $history->rhDestUId = null; // for secretariat destination
                        $history->rhRId = $req->id;
                        $history->rhRsId = $req->rRsId;
                        $history->rhPrId = $currentVerifier->prvPrId;
                        $history->save();

                        $srQueue = new SecretariatRequestQueue();
                        $srQueue->srqRId = $req->id;
                        $srQueue->save();
                    }

                    SystemLog::setFinancialSubSystemLog('تایید درخواست پرداخت توسط ' . Auth::user()->name);
                    $rController = new RequestController();
                    return \response()->json(
                        $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                    );
                });

                return $result;

            }else{
                return response()->json([] , 406); //Exist verifiers before you
            }
        }else{
            return response()->json([] , 405);
        }
    }

    public function numbering(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $payRequest = PayRequest::find($request->prId);
            $payRequest->prLetterNumber = $request->letterNumber;
            $payRequest->prLetterDate = $request->letterDate;
            $payRequest->save();

            $req = _Request::find($request->rId);
            if ($req->rAcceptedAmount != $req->rCommitmentAmount)
            {
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'FINANCIAL')->value('id');

                RequestHistoryLastPoint::updateOrCreate(['rhlpRId' => $req->id] , [
                    'rhlpRlId' => RequestLevel::where('rlLevel' , '=' , 'PAYMENT')->value('id'),
                    'rhlpRsId' => RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id'),
                    'rhlpPrId' => $payRequest->id,
                    'rhlpDescription' => 'با توجه به درصد افزایش / کاهش مبلغ قرارداد و تفاوت مبلغ جدید با مبلغ تعهد شده، درخواست نیاز به اصلاح تامین اعتبار دارد.'
                ]);
            }else{
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PAYMENT')->value('id');
            }
            $req->save();

            SecretariatRequestQueue::where('srqRId' , '=' , $req->id)->delete();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhPrId = $payRequest->id;
            $history->save();

            $finReqQueue = new FinancialRequestQueue();
            $finReqQueue->frqRId = $req->id;
            $finReqQueue->save();

            SystemLog::setFinancialSubSystemLog('ثبت درخواست پرداخت در دبیرخانه برای درخواست ' . $req->rSubject . ' در دبیرخانه');

            $rController = new RequestController();
            return \response()->json(
                $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }

    public function wasSeen(Request $request)
    {
        $rHistory = RequestHistory::find($request->rhId);
        $rHistory->rhPrHasBeenSeen = true;
        $rHistory->save();

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
        );
    }

    public function block(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $payRequest = PayRequest::with('contract')->find($request->prId);
            $payRequest->prPrsId = PayRequestState::where('prsState' , '=' , 'BLOCKED')->value('id');
            $payRequest->save();

            $req = _Request::find($payRequest->prRId);
            if ($request->prId == $request->lastRefPrId)
            {
                $req->rRsId = RequestState::where('rsState' , '=' , 'WAITING_FOR_PAY_REQUEST')->value('id');
                $req->save();
            }

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = Auth::user()->id; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhPrId = $payRequest->id;
            $history->rhPrHasBeenSeen = true;
            $history->rhHasBeenSeen = true;
            $history->rhDescription = PublicSetting::checkPersianCharacters($request->description) . ' (مسدود کردن درخواست پرداخت: ' . $payRequest->contract->cSubject . ')';
            $history->save();

            SystemLog::setFinancialSubSystemLog('مسدود کردن درخواست پرداخت برای قرارداد ' . $payRequest->contract->cSubject);
            $rController = new RequestController();
            return \response()->json(
                $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }

}
