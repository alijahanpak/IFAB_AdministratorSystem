<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\CheckVerifier;
use Modules\Financial\Entities\Draft;

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
        //return \response()->json(Auth::user()->seFiscalYear , 500);
        DB::transaction(function () use($request){
            _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => null , 'cFyId' => Auth::user()->seFiscalYear] , [
                'cAmount' => $request->baseCheckAmount
            ]);

            //////////////////////// set decrease checks ////////////////////////////////
            if (is_array($request->get('decreases')))
            {
                foreach ($request->get('decreases') as $item)
                {
                    _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => $item['id'] , 'cFyId' => Auth::user()->seFiscalYear] , [
                        'cAmount' => $item['amount']
                    ]);
                }
            }

            SystemLog::setFinancialSubSystemLog('صدور چک های حواله ' . Draft::find($request->dId)->dFor);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

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
