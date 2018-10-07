<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CheckVerifier;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;

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

            $req = _Request::with('requestType')->find(Draft::find($request->dId)->dRId);
            if ($req['request_type']['rtType'] == 'BUY_SERVICES')
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
        return response()->json(
            _Check::where('cFyId' , '=' , Auth::user()->seFiscalYear)
                ->where('cDelivered' , '=' , false)
                ->with('percentageDecrease')
                ->with('draft')
                ->paginate(20)
        );
    }
}
