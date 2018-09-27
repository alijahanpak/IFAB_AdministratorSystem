<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        DB::transaction(function () use($request){
            _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => null] , [
                'cAmount' => $request->baseCheckAmount
            ]);

            //////////////////////// set decrease checks ////////////////////////////////
            if (is_array($request->get('decreases')))
            {
                foreach ($request->get('decreases') as $item)
                {
                    _Check::updateOrCreate(['cDId' => $request->dId , 'cPdId' => $item['id']] , [
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
}
