<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\RequestType;

class RequestController extends Controller
{
    function fetchRequestTypes(Request $request)
    {
        $rType = RequestType::all();
        return \response()->json($rType);
    }

    function fetchPostedRequestsData(Request $request)
    {
        $req = _Request::where('rUId' , Auth::user()->id)
            ->with('requestState')
            ->with('requestType')
            ->with('requestCommodity.commodity')
            ->get();
        return \response()->json($req);
    }

    function register(Request $request)
    {
        $req = new _Request();
        $req->rSubject = $request->subject;
        if ($request->type == 'BUY_SERVICES') {

        } else if($request->type == 'BUY_COMMODITY'){

        } else if ($request->type == 'FUND'){

        }

        return $request->type;
    }
}
