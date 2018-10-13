<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CheckFormat;
use Modules\Financial\Entities\CheckVerifier;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestStep;
use Modules\Financial\Entities\RequestType;

class CheckController extends Controller
{
    public function getCheckVerifier(Request $request)
    {
        return \response()->json(
            CheckVerifier::with('user.role')->has('user')->get()
        );
    }

    public function generateChecks(Request $request)
    {
        DB::transaction(function () use($request){
            $insertedAId = array();
            $i = 0;
            $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => null , 'cFyId' => Auth::user()->seFiscalYear] , [
                'cAmount' => $request->baseCheckAmount
            ]);
            $insertedAId[$i++] = $check->id;

            //////////////////////// set decrease checks ////////////////////////////////
            if (is_array($request->get('decreases')))
            {
                foreach ($request->get('decreases') as $item)
                {
                    $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => $item['id'] , 'cFyId' => Auth::user()->seFiscalYear] , [
                        'cAmount' => $item['amount']
                    ]);
                    $insertedAId[$i++] = $check->id;
                }
            }

            _Check::whereNotIn('id' , $insertedAId)
                ->where('cDId' , '=' , $request->dId)
                ->delete();

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

            SystemLog::setFinancialSubSystemLog('صدور چک های حواله ' . Draft::find($request->dId)->dFor);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

/*    public function generateChecks(Request $request)
    {
        DB::transaction(function () use($request){
            $insertedAId = array();
            $i = 0;
            $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => null , 'cFyId' => Auth::user()->seFiscalYear] , [
                'cAmount' => $request->baseCheckAmount
            ]);
            $insertedAId[$i++] = $check->id;

            //////////////////////// set decrease checks ////////////////////////////////
            if (is_array($request->get('decreases')))
            {
                foreach ($request->get('decreases') as $item)
                {
                    $check = _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => $item['id'] , 'cFyId' => Auth::user()->seFiscalYear] , [
                        'cAmount' => $item['amount']
                    ]);
                    $insertedAId[$i++] = $check->id;
                }
            }

            _Check::whereNotIn('id' , $insertedAId)
                ->where('cDId' , '=' , $request->dId)
                ->delete();

            SystemLog::setFinancialSubSystemLog('صدور چک های حواله ' . Draft::find($request->dId)->dFor);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }*/

    public function fetchAllChecks(Request $request)
    {
        $searchValue = PublicSetting::checkPersianCharacters($request->searchValue);
        return response()->json(
            _Check::where('cFyId' , '=' , Auth::user()->seFiscalYear)
                ->where(function ($q) use($searchValue){
                    return $q->where('cDate' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('cAmount' , '=' , $searchValue)
                        ->orWhere('cIdNumber' , '=' , $searchValue)
                        ->orWhereHas('percentageDecrease' , function ($query) use($searchValue){
                            return $query->where('pdSubject' , 'LIKE' , '%' . $searchValue . '%');
                        })
                        ->orWhereHas('draft' , function ($query) use($searchValue){
                            return $query->where('dFor' , 'LIKE' , '%' . $searchValue . '%')
                                ->orWhere('dPayTo' , '=' , $searchValue);
                        });
                })
                ->with('draft')
                ->with('percentageDecrease')
                ->orderBy('id' , 'DESC')
                ->paginate(20)
        );
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
}
