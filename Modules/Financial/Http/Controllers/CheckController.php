<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\User;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\CapSpent;
use Modules\Financial\Entities\CheckFormat;
use Modules\Financial\Entities\CheckState;
use Modules\Financial\Entities\CheckVerifier;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\CostSpent;
use Modules\Financial\Entities\Deposit;
use Modules\Financial\Entities\DepositState;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\PrintHistory;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestStep;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\SelectedCheckVerifier;

class CheckController extends Controller
{
    public function getCheckVerifier(Request $request)
    {
        return \response()->json(
            CheckVerifier::with(['user' => function($q){
                return $q->where('isActive' , true)->with('role');
            }])
                ->orderBy('cvOrder')
                ->get()
        );
    }

    public function generateChecks(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $insertedAId = array();
            $i = 0;
            //////////////////////// set base checks ////////////////////////////////
            if (is_array($request->get('baseCheckAmounts')))
            {
                foreach ($request->get('baseCheckAmounts') as $item)
                {
                    $currentCheck = _Check::where('cDId' , $request->dId)
                        ->where('cPayTo' , $item['payTo'])
                        ->where('cFyId' , Auth::user()->seFiscalYear)
                        ->first();
                    $checkState = $currentCheck ? $currentCheck->cCsId : CheckState::where('csState' , 'WAITING_FOR_PRINT')->value('id');
                    $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cPayTo' => $item['payTo'] , 'cFyId' => Auth::user()->seFiscalYear] , [
                        'cAmount' => $item['amount'],
                        'cFor' => $item['for'],
                        'cCsId' => $checkState
                    ]);
                    $insertedAId[$i++] = $check->id;
                }
            }
            //////////////////////// set decrease checks ////////////////////////////////
            if (is_array($request->get('decreases')))
            {
                foreach ($request->get('decreases') as $item)
                {
                    $currentCheck = _Check::where('cDId' , $request->dId)
                        ->where('cPdId' , $item['id'])
                        ->where('cFyId' , Auth::user()->seFiscalYear)
                        ->first();
                    $checkState = $currentCheck ? $currentCheck->cCsId : CheckState::where('csState' , 'WAITING_FOR_PRINT')->value('id');
                    $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => $item['id'] , 'cFyId' => Auth::user()->seFiscalYear] , [
                        'cAmount' => $item['amount'],
                        'cCsId' => $checkState
                    ]);
                    $insertedAId[$i++] = $check->id;
                }
            }
            //////////////////////// set deposit checks ////////////////////////////////
            $insertedDId = array();
            $j = 0;
            if (is_array($request->get('deposits')))
            {
                foreach ($request->get('deposits') as $item)
                {
                    $deposit = Deposit::updateOrCreate(['dDrId' => $request->dId , 'dDpId' => $item['id']] , [
                        'dAmount' => $item['amount'],
                        'dDsId' => DepositState::where('dsState' , 'OWE')->value('id')
                    ]);

                    $insertedDId[$j++] = $deposit->id;

                    $currentCheck = _Check::where('cDId' , $request->dId)
                        ->where('cDpId' , $deposit->id)
                        ->where('cFyId' , Auth::user()->seFiscalYear)
                        ->first();

                    $checkState = $currentCheck ? $currentCheck->cCsId : CheckState::where('csState' , 'WAITING_FOR_PRINT')->value('id');
                    $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cDpId' => $deposit->id , 'cFyId' => Auth::user()->seFiscalYear] , [
                        'cAmount' => $item['amount'],
                        'cCsId' => $checkState
                    ]);

                    $insertedAId[$i++] = $check->id;
                }
            }

            ///////////////////////////////////////////////////////

            _Check::whereNotIn('id' , $insertedAId)
                ->where('cDId' , '=' , $request->dId)
                ->delete();

            Deposit::whereNotIn('id' , $insertedDId)
                ->where('dDrId' , $request->dId)
                ->delete();

            SystemLog::setFinancialSubSystemLog('صدور چک های حواله ' . Draft::find($request->dId)->dFor);
            $rController = new RequestController();
            if ($request->resultType == 'RECEIVED')
            {
                $req = _Request::with('requestType')->find($request->rId);
                if ($req->rRtId == RequestType::where('rtType' , '=' ,'BUY_SERVICES')->value('id'))
                {
                    if (!$req->rIsPayRequestClosed)
                    {
                        $req->rRsId = RequestState::where('rsState' , '=' , 'WAITING_FOR_PAY_REQUEST')->value('id');
                        $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'PAYMENT')->value('id');
                        $req->save();

                        // make history for this request
                        $history = new RequestHistory();
                        $history->rhSrcUId = Auth::user()->id;
                        $history->rhDestUId = null; // for secretariat destination
                        $history->rhRId = $req->id;
                        $history->rhRsId = $req->rRsId;
                        $history->save();
                    }
                }

                return \response()->json(
                    $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList() , $request->searchValue)
                );
            }else if ($request->resultType == 'SEARCH'){
                return $rController->normalSearch($request);
            }

        });

        return $result;
    }

    public function fetchAllChecks(Request $request)
    {
        return response()->json(
            $this->getAllChecks($request->searchValue)
        );
    }

    private function getAllChecks($searchValue)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return _Check::where('cFyId' , '=' , Auth::user()->seFiscalYear)
            ->where(function ($q) use($searchValue){
                return $q->where('cDate' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cPayTo' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cFor' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cAmount' , '=' , $searchValue)
                    ->orWhere('cIdNumber' , '=' , $searchValue)
                    ->orWhereHas('percentageDecrease' , function ($query) use($searchValue){
                        return $query->where('pdSubject' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->orWhereHas('checkState' , function ($query) use($searchValue){
                        return $query->where('csSubject' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->orWhereHas('draft' , function ($query) use($searchValue){
                        return $query->where('dFor' , 'LIKE' , '%' . $searchValue . '%')
                            ->orWhere('dPayTo' , '=' , $searchValue);
                    });
            })
            ->with('draft')
            ->with('percentageDecrease')
            ->with('deposit.depositPercentage')
            ->with('checkState')
            ->with('printHistory')
            ->with('selectedVerifiers.verifier.user.role')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
    }

    public function registerNewFormat(Request $request)
    {
        DB::transaction(function () use($request){
            $format = new CheckFormat();
            $format->cfSubject = PublicSetting::checkPersianCharacters($request->subject);
            $format->cfState = $request->state;
            $format->cfDateTop = $request->dateTop;
            $format->cfDateRight = $request->dateRight;
            $format->cfDateWidth = $request->dateWidth;
            $format->cfStringDateTop = $request->stringDateTop;
            $format->cfStringDateRight = $request->stringDateRight;
            $format->cfStringDateWidth = $request->stringDateWidth;
            $format->cfForTop = $request->forTop;
            $format->cfForRight = $request->forRight;
            $format->cfForWidth = $request->forWidth;
            $format->cfPayToTop = $request->payToTop;
            $format->cfPayToRight = $request->payToRight;
            $format->cfPayToWidth = $request->payToWidth;
            $format->cfStringAmountTop = $request->stringAmountTop;
            $format->cfStringAmountRight = $request->stringAmountRight;
            $format->cfStringAmountWidth = $request->stringAmountWidth;
            $format->cfAmountTop = $request->amountTop;
            $format->cfAmountRight = $request->amountRight;
            $format->cfAmountWidth = $request->amountWidth;
            $format->cfSignatureTop = $request->signatureTop;
            $format->cfSignatureRight = $request->signatureRight;
            $format->cfSignatureWidth = $request->signatureWidth;
            $format->cfSecondSignatureTop = $request->secondSignatureTop;
            $format->cfSecondSignatureRight = $request->secondSignatureRight;
            $format->cfSecondSignatureWidth = $request->secondSignatureWidth;
            $format->cfWidth = $request->width;
            $format->cfHeight = $request->height;
            $format->save();

            SystemLog::setFinancialSubSystemLog('ایجاد قالب چک جدید با عنوان ' . $request->subject);
        });

        return response()->json($this->getAllCheckFormat());
    }

    public function fetchAllCheckFormat()
    {
        return response()->json($this->getAllCheckFormat());
    }

    public function getAllCheckFormat()
    {
        return CheckFormat::all();
    }

    public function getActiveCheckFormat()
    {
        return CheckFormat::where('cfState' , '=' , true)->get();
    }

    public function updateCheckFields(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (!_Check::where('cIdNumber' , $request->idNumber)->exists())
            {
                $checkVerifiers = CheckVerifier::whereIn('id' , $request->verifiers)->with('user.role')->orderBy('cvOrder')->get();
                //$user = User::where('id' , $checkVerifier->cvUId)->with('role')->first();

                $check = _Check::where('id' , $request->cId)->first();
                $check->cDate = $request->date;
                $check->cCsId = $check->cCsId == CheckState::where('csState' , 'WAITING_FOR_PRINT')->value('id') ? CheckState::where('csState' , 'WAITING_FOR_DELIVERY')->value('id') : $check->cCsId;
                $check->cIdNumber = $request->idNumber;
                $check->save();

                SelectedCheckVerifier::where('scvCId' , $check->id)->delete();

                foreach ($checkVerifiers as $cv)
                {
                    $selectedCheckVerifier = new SelectedCheckVerifier();
                    $selectedCheckVerifier->scvCId = $check->id;
                    $selectedCheckVerifier->scvCvId = $cv->id;
                    $selectedCheckVerifier->save();

                }

                $printHistory = new PrintHistory();
                $printHistory->phCId = $request->cId;
                $printHistory->phDate = $check->cDate;
                $printHistory->phIdNumber = $check->cIdNumber;
                $printHistory->phVerifierName = $checkVerifiers[0]->user->name . ' - ' . $checkVerifiers[0]->user->role->rSubject;
                if (count($checkVerifiers) > 1)
                    $printHistory->phSecondVerifierName = $checkVerifiers[1]->user->name . ' - ' . $checkVerifiers[1]->user->role->rSubject;
                $printHistory->phCheckFormat = $request->cfSubject;
                $printHistory->phAmount = $check->cAmount;
                $printHistory->phDescription = PublicSetting::checkPersianCharacters($request->description);
                $printHistory->save();

                SystemLog::setFinancialSubSystemLog('چاپ چک شماره ' .  $request->idNumber);

                return response()->json(
                    $this->getAllChecks($request->searchValue)
                );
            }else{
                return response()->json(
                    $this->getAllChecks($request->searchValue)
                , 409);
            }

        });

        return $result;
    }

    public function deliver(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $check = _Check::where('id' , $request->cId)->with('draft')->first();
            $check->cCsId = CheckState::where('csState' , 'DELIVERED')->value('id');
            $check->cDeliveryDate = $request->date;
            $check->save();

            $checkRemainingAmount = 0;
            $req = _Request::find($check->draft->dRId);
            if ($req->rRtId != RequestType::where('rtType' , 'FUND')->value('id')) {
                $costFinancing = CostFinancing::where('cfRId', $check->draft->dRId)->get()->sortBy('cfRemainingAmount');
                $capFinancing = CapitalAssetsFinancing::where('cafRId', $check->draft->dRId)->get()->sortBy('cafRemainingAmount');

                do {
                    $lastModifyCheck = _Check::find($check->id);
                    $checkRemainingAmount = $check->cAmount - $lastModifyCheck->cSpentAmount;
                    foreach ($costFinancing as $cf) {
                        $lastModifyCostFinancing = CostFinancing::where('id', $cf->id)->first();
                        $calcAmount = $lastModifyCostFinancing->cfRemainingAmount <= $checkRemainingAmount ? $lastModifyCostFinancing->cfRemainingAmount : $checkRemainingAmount;

                        if ($calcAmount > 0) {
                            $costSpent = new CostSpent();
                            $costSpent->csCfId = $cf->id;
                            $costSpent->csCId = $check->id;
                            $costSpent->csAmount = $calcAmount;
                            $costSpent->save();

                            $checkRemainingAmount -= $calcAmount;
                        }
                    }

                    foreach ($capFinancing as $caf) {
                        $lastModifyCapFinancing = CapitalAssetsFinancing::find($caf->id);
                        $calcAmount = $lastModifyCapFinancing->cafRemainingAmount <= $checkRemainingAmount ? $lastModifyCapFinancing->cafRemainingAmount : $checkRemainingAmount;

                        if ($calcAmount > 0) {
                            $capSpent = new CapSpent();
                            $capSpent->csCafId = $caf->id;
                            $capSpent->csCId = $check->id;
                            $capSpent->csAmount = $calcAmount;
                            $capSpent->save();

                            $checkRemainingAmount -= $calcAmount;
                        }
                    }
                } while ($checkRemainingAmount > 0);
            }
            if ($checkRemainingAmount != 0)
            {
                throw new \Exception(500);
            }
            else{
                SystemLog::setFinancialSubSystemLog('تحویل چک شماره ' .  $check->cIdNumber);
                return response()->json($this->getAllChecks($request->searchValue));
            }
        });

        return $result;
    }
}
