<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\RoleCategory;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\Commodity;
use Modules\Financial\Entities\RequestCommodity;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestStep;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\RequestVerifiers;

class RequestController extends Controller
{
    function fetchRequestTypes(Request $request)
    {
        $rType = RequestType::all();
        return \response()->json($rType);
    }

    function fetchRequestSteps(Request $request)
    {
        $userCat = RoleCategory::where('rcRId' , '=' , Auth::user()->rId)->pluck('rcCId');
        $rType = RequestStep::whereHas('requestType' , function ($q) use($request){
            return $q->where('rtType' , '=' , $request->requestType);
        })->whereHas('category' , function ($q) use($userCat){
            return $q->whereNotIn('id' , $userCat);
        })->where('rstOrder' , '<>' , 1)
            ->with('category.roleCategory.role.user')
            ->orderBy('rstOrder')
            ->get();
        return \response()->json($rType);
    }

    function fetchPostedRequestsData(Request $request)
    {
        $req = $this->getAllPostedRequests(Auth::user()->id);
        return \response()->json($req);
    }

    function getAllPostedRequests($uId)
    {
        return _Request::where('rUId' , $uId)
            ->with('requestState')
            ->with('requestType')
            ->with('requestCommodity.commodity')
            ->with('history.sourceUserInfo.role')
            ->with('history.destinationUserInfo.role')
            ->with('history.requestState')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
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
                $reqComm = new RequestCommodity();
                $reqComm->rcRId = $req->id;
                $reqComm->rcCId = $cId->id;
                $reqComm->rcCount = $item['count'];
                $reqComm->rcCostEstimation = $item['costEstimation'];
                $reqComm->rcDescription = PublicSetting::checkPersianCharacters($item['description']);
                $reqComm->save();
            }
        }

        //////////////////////// set verifiers ////////////////////////////////
        $userSig = Signature::where('sUId' , '=' , Auth::user()->id)->first();
        if ($userSig == null)
            return response()->json([] , 500);

        $userCat = RoleCategory::where('rcRId' , '=' , Auth::user()->rId)->pluck('rcCId');
        $mySteps = RequestStep::where('rstRtId' , '=' , $request->rtId)
            ->whereIn('rstCId' , $userCat)
            ->orderBy('rstOrder')
            ->get();

        $firstStepId = RequestStep::where('rstRtId' , '=' , $request->rtId)
            ->orderBy('rstOrder')
            ->first();

        RequestVerifiers::firstOrCreate(['rvSId' => $userSig->id , 'rvRstId' => $firstStepId->id , 'rvRId' => $req->id , 'rvUId' => Auth::user()->id]);
        foreach ($mySteps as $myStep)
        {
            RequestVerifiers::firstOrCreate(['rvSId' => $userSig->id , 'rvRstId' => $myStep->id , 'rvRId' => $req->id , 'rvUId' => Auth::user()->id]);
        }

        if (is_array($request->get('verifiers'))) {
            foreach ($request->get('verifiers') as $verifiers){
                RequestVerifiers::firstOrCreate(['rvRstId' => $verifiers['rstId'], 'rvRId' => $req->id, 'rvUId' => $verifiers['uId']]);
            }
        }
        ///////////////////////////////////////////////////////////////////////
        // make history for this request
        $history = new RequestHistory();
        $history->rhSrcUId = Auth::user()->id;
        $history->rhDestUId = $request->get('verifiers')[0]['uId'];
        $history->rhRId = $req->id;
        $history->rhRsId = $req->rRsId;
        $history->save();

        SystemLog::setFinancialSubSystemLog('ثبت درخواست ' . $reqType->rtSubject);
        return \response()->json(
            $this->getAllPostedRequests(Auth::user()->id)
        );
    }

    function fetchReceivedRequestsData(Request $request)
    {
        $req = RequestHistory::selectRaw('rhRId , MAX(id) as id')
            ->where('rhDestUId' , '=' , Auth::user()->id)
            ->groupBy('rhRId')
            ->pluck('rhRId');
        return \response()->json(
            $this->getAllReceivedRequests($req)
        );
    }

    function getAllReceivedRequests($reqIds)
    {
        return _Request::whereIn('id' , $reqIds)
            ->with('requestState')
            ->with('requestType')
            ->with('requestCommodity.commodity')
            ->with('history.sourceUserInfo.role')
            ->with('history.destinationUserInfo.role')
            ->with('history.requestState')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
    }
}
