<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Container;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\Contract;
use Modules\Financial\Entities\Executor;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\IncreaseContractAmount;
use Modules\Financial\Entities\PercentageIncrease;
use Modules\Financial\Entities\PercentageIncreaseCategory;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;

class ContractController extends Controller
{
    function addNewContract(Request $request)
    {
        DB::transaction(function () use($request){
            $eId = Executor::firstOrCreate(['eSubject' => PublicSetting::checkPersianCharacters(trim($request->executor))]);
            $contract = new Contract();
            $contract->cRId = $request->rId;
            $contract->cEId = $eId->id;
            $contract->cSubject = PublicSetting::checkPersianCharacters($request->subject);
            $contract->cBaseAmount = $request->baseAmount;
            $contract->cPercentInAndDec = $request->percentIncAndDec;
            $contract->cCoefficient = $request->coefficient;
            $contract->cLetterNumber = $request->letterNumber;
            $contract->cLetterDate = $request->letterDate;
            $contract->cStartDate = $request->startDate;
            $contract->cEndDate = $request->endDate;
            $contract->cDescription = PublicSetting::checkPersianCharacters($request->description);
            $contract->save();

            //////////////////////// set increases items ////////////////////////////////
            if (is_array($request->get('increaseItems')))
            {
                foreach ($request->get('increaseItems') as $item)
                {
                    $increaseContractAmount = new IncreaseContractAmount();
                    $increaseContractAmount->icaCId = $contract->id;
                    $increaseContractAmount->icaPiId = $item['piId'];
                    $increaseContractAmount->icaAmount = $item['amount'];
                    $increaseContractAmount->save();
                }
            }

            SystemLog::setFinancialSubSystemLog('ثبت قرارداد ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
        );
    }

    public function update(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $eId = Executor::firstOrCreate(['eSubject' => PublicSetting::checkPersianCharacters(trim($request->executor))]);
            $contract = Contract::find($request->id);
            $contract->cEId = $eId->id;
            $contract->cSubject = PublicSetting::checkPersianCharacters($request->subject);
            $contract->cBaseAmount = $request->baseAmount;
            $contract->cPercentInAndDec = $request->percentIncAndDec;
            $contract->cCoefficient = $request->coefficient;
            $contract->cLetterNumber = $request->letterNumber;
            $contract->cLetterDate = $request->letterDate;
            $contract->cStartDate = $request->startDate;
            $contract->cEndDate = $request->endDate;
            $contract->cDescription = PublicSetting::checkPersianCharacters($request->description);
            $contract->save();

            //////////////////////// set increases items ////////////////////////////////
            if (is_array($request->get('increaseItems')))
            {
                $increaseItemIds = [];
                $i = 0;
                foreach ($request->get('increaseItems') as $item)
                {
                    $inc = IncreaseContractAmount::updateOrCreate(['icaCId' => $contract->id , 'icaPiId' => $item['piId']], [
                        'icaAmount' => $item['amount']
                    ]);
                    $increaseItemIds[$i++] = $inc->id;
                }

                if (count($increaseItemIds) > 0)
                {
                    IncreaseContractAmount::whereNotIn('id' , $increaseItemIds)
                        ->where('icaCId' , $contract->id)
                        ->delete();
                }
            }

            SystemLog::setFinancialSubSystemLog('اصلاح قرارداد ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
            $rController = new RequestController();
            return \response()->json($rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue));
        });

        return $result;
    }

    function accept(Request $request)
    {
        DB::transaction(function () use($request){
            Contract::where('cRId' , '=' , $request->rId)
                ->update(['cIsAccepted' => true]);

            $req = _Request::find($request->rId);
            if ($req->rAcceptedAmount != $req->rCommitmentAmount)
            {
                $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'FINANCIAL')->value('id');

                RequestHistoryLastPoint::updateOrCreate(['rhlpRId' => $req->id] , [
                    'rhlpRlId' => RequestLevel::where('rlLevel' , '=' , 'PAYMENT')->value('id'),
                    'rhlpRsId' => RequestState::where('rsState' , '=' , 'WAITING_FOR_PAY_REQUEST')->value('id'),
                    'rhlpPrId' => null,
                    'rhlpDescription' => 'با توجه به تفاوت مبلغ قرارداد با مبلغ تعهد شده، درخواست نیاز به اصلاح تامین اعتبار دارد.'
                ]);
            }
            else
            {
                $req->rRsId = RequestState::where('rsState' , '=' , 'WAITING_FOR_PAY_REQUEST')->value('id');
                $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PAYMENT')->value('id');
            }
            $req->save();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = null; // for secretariat destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->save();

            if ($req->rAcceptedAmount != $req->rCommitmentAmount)
            {
                $finReqQueue = new FinancialRequestQueue();
                $finReqQueue->frqRId = $req->id;
                $finReqQueue->save();
            }

            SystemLog::setFinancialSubSystemLog('تایید قرارداد های درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
        );
    }

    function delete(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $rController = new RequestController();
            $contract = Contract::where('id' , '=' , $request->cId)->first();
            if ($contract->cIsAccepted == false)
            {
                Contract::where('id' , '=' , $request->cId)->delete();
                return \response()->json($rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue));
            }else{
                return \response()->json($rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue) , 204);
            }
        });

        return $result;

    }

    function getPercentageIncrease()
    {
        return \response()->json(
            PercentageIncreaseCategory::whereHas('percentageIncrease' , function ($q){
                return $q->where('piState' , '=' , true);
            })->where('picState' , true)
                ->with('percentageIncrease')
                ->get()
        );
    }
}
