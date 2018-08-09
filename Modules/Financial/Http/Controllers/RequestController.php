<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\Commodity;
use Modules\Financial\Entities\RequestCommodity;
use Modules\Financial\Entities\RequestState;
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
        $req = $this->getAllRequests(Auth::user()->id);
        return \response()->json($req);
    }

    function getAllRequests($uId)
    {
        return _Request::where('rUId' , $uId)
            ->with('requestState')
            ->with('requestType')
            ->with('requestCommodity.commodity')
            ->orderBy('id' , 'DESC')
            ->get();
    }

    function register(Request $request)
    {
        $reqType = RequestType::find($request->rtId);
        $req = new _Request();
        $req->rRsId = RequestState::where('rsState' , '=' , 'ACTIVE')->value('id');
        $req->rRtId = $request->rtId;
        $req->rUId = Auth::user()->id;
        $req->rSubject = PublicSetting::checkPersianCharacters($request->subject);
        $req->rCostEstimation = $request->costEstimation;
        $req->rDescription = PublicSetting::checkPersianCharacters($request->description);
        $req->rFurtherDetails = PublicSetting::checkPersianCharacters($request->furtherDetails);
        $req->save();

        if (is_array($request->get('items')))
        {
            foreach ($request->get('items') as $item)
            {
                $cId = Commodity::firstOrCreate(['cSubject' => PublicSetting::checkPersianCharacters($item['subject'])]);
                echo $cId->id;
                $reqComm = new RequestCommodity();
                $reqComm->rcRId = $req->id;
                $reqComm->rcCId = $cId->id;
                $reqComm->rcCount = $item['count'];
                $reqComm->rcCostEstimation = $item['costEstimation'];
                $reqComm->rcDescription = PublicSetting::checkPersianCharacters($item['description']);
                $reqComm->save();
            }
        }

        SystemLog::setFinancialSubSystemLog('ثبت درخواست ' . $reqType->rtSubject);
        return \response()->json(
            $this->getAllRequests(Auth::user()->id)
        );
    }
}
