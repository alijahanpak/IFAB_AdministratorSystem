<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\AccountantRequestQueue;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\PayRequest;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\SecretariatRequestQueue;

class NumberingController extends Controller
{
    public function requestNumbering(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (!$this->checkDuplicateNumber($request->letterNumber))
            {
                $req = _Request::find($request->rId);
                $req->rLetterNumber = $request->letterNumber;
                $req->rLetterDate = $request->letterDate;
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'FINANCIAL')->value('id');
                $req->save();

                SecretariatRequestQueue::where('srqRId' , '=' , $req->id)->delete();

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

                SystemLog::setFinancialSubSystemLog('شماره گذاری درخواست ' . $req->rSubject . ' در دبیرخانه');

                $rController = new RequestController();
                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                );
            }else{
                $rController = new RequestController();
                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                , 409);
            }

        });

        return $result;
    }

    public function draftNumbering(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $rController = new RequestController();
            if (!$this->checkDuplicateNumber($request->letterNumber))
            {
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

                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                );
            }else{
                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                , 409);
            }
        });

        return $result;

    }

    public function payRequestNumbering(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $rController = new RequestController();
            if (!$this->checkDuplicateNumber($request->letterNumber))
            {
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

                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                );
            }else{
                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                , 409);
            }
        });

        return $result;
    }

    function checkDuplicateNumber($number)
    {
        if (_Request::where('rLetterNumber' , $number)->exists())
            return true;
        elseif (Draft::where('dLetterNumber' , $number)->exists())
            return true;
        elseif (PayRequest::where('prLetterNumber' , $number)->exists())
            return true;
    }
}
