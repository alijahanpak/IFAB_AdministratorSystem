<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\GroupPermission;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\RoleCategory;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\UserGroup;
use Modules\Budget\Entities\CostAllocation;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\Commodity;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RequestCommodity;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestStep;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\RequestVerifiers;
use Modules\Financial\Entities\SecretariatRequestQueue;

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
        return _Request::where('rUId' , '=' , $uId)
            ->with('requestState')
            ->with('requestType')
            ->with('verifiers.user.role.officeUnit')
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
        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList())
        );
    }

    function getAllReceivedRequests($reqIds)
    {
        return _Request::whereIn('id' , $reqIds)
            ->where('rRsId' , '=' , RequestState::where('rsState' , '=' , 'ACTIVE')->value('id'))
            ->with('requestState')
            ->with('requestType')
            ->with('verifiers.user.role.officeUnit')
            ->with('requestCommodity.commodity')
            ->with('history.sourceUserInfo.role')
            ->with('history.destinationUserInfo.role')
            ->with('history.requestState')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
    }

    function normalSearch(Request $request)
    {
        $searchValue = PublicSetting::checkPersianCharacters($request->searchValue);
        $result = _Request::where('rSubject' , 'LIKE' , '%' . $searchValue . '%')
            ->orWhere('rDescription' , 'LIKE' , '%' . $searchValue . '%')
            ->orWhere('rLetterNumber' , 'LIKE' , '%' . $searchValue . '%')
            ->orWhere('rLetterDate' , 'LIKE' , '%' . $searchValue . '%')
            ->orWhere('rCostEstimation' , '=' , $searchValue)
            ->orWhereHas('creator' , function ($q) use($searchValue){
                return $q->where('name' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->orWhereHas('requestType' , function ($q) use($searchValue){
                return $q->where('rtSubject' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->orWhereHas('requestState' , function ($q) use($searchValue){
                return $q->where('rsSubject' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->with('requestState')
            ->with('requestType')
            ->with('requestCommodity.commodity')
            ->with('history.sourceUserInfo.role')
            ->with('history.destinationUserInfo.role')
            ->with('history.requestState')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
        return response()->json($result);
    }

    public function referral(Request $request)
    {
        $rHis = RequestHistory::find($request->lastRefId);
        if ($request->acceptPermission == true)
        {
            $verifier = RequestVerifiers::find($request->verifierId);
            $verifier->rvUId = $request->destUId;
            $verifier->save();
        }
        // make history for this request
        $history = new RequestHistory();
        $history->rhSrcUId = Auth::user()->id;
        $history->rhDestUId = $request->destUId;
        $history->rhRId = $rHis->rhRId;
        $history->rhRsId = $rHis->rhRsId;
        $history->rhIsReferral = $request->acceptPermission ? false : true;
        $history->rhDescription = PublicSetting::checkPersianCharacters($request->description);
        $history->save();

        if ($request->acceptPermission == true)
        {
            SystemLog::setFinancialSubSystemLog('ارجاع درخواست با انتقال مجوز تایید');
        }else{
            SystemLog::setFinancialSubSystemLog('ارجاع درخواست');
        }
        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList())
        );
    }

    public function getLastReceivedRequestIdList()
    {
        /////////// check access to secretariat queue permission //////////////////////
        $gIDs = UserGroup::where('ugUId' , '=' , Auth::user()->id)->pluck('ugGId')->toArray();
        $accessToSQPermission = GroupPermission::whereIn('gpGId' , $gIDs)
            ->whereHas('permission' , function ($q){
                return $q->where('pPermission' , '=' , 'SECRETARIAT_QUEUE_DISPLAY');
            })
            ->count();
        if ($accessToSQPermission)
        {
            $secQueue = SecretariatRequestQueue::all()->pluck('srqRId');
            RequestHistory::whereIn('rhRId' , $secQueue)
                ->where('rhRsId' , '=' , RequestState::where('rsState' , '=' , 'SECRETARIAT_QUEUE')->value('id'))
                ->update(['rhDestUId' => Auth::user()->id , 'rhRsId' => RequestState::where('rsState' , '=' , 'ACTIVE')->value('id')]);
            _Request::whereIn('id' , $secQueue)->update(['rRsId' => RequestState::where('rsState' , '=' , 'ACTIVE')->value('id')]);
            SecretariatRequestQueue::whereIn('srqRId' , $secQueue)->delete();
        }

        $rhIds = RequestHistory::selectRaw('rhRId , MAX(id) as id')
            ->groupBy('rhRId')
            ->pluck('id');
        $req = RequestHistory::whereIn('id' , $rhIds)
            ->where('rhDestUId' , '=' , Auth::user()->id)
            ->orderBy('id' , 'DESC')
            ->pluck('rhRId');
        return $req;
    }

    public function accept(Request $request)
    {
        $requestClosed = false;
        $sig = Signature::where('sUId' , '=' , Auth::user()->id)->first();
        $currentVerifier = RequestVerifiers::find($request->verifierId);
        $req = _Request::find($currentVerifier->rvRId);

        if ($currentVerifier->rvUId == Auth::user()->id)
        {
            if (count($req->rRemainingVerifiers) == 0)
            {
                // determine exist item with warehouse keeper
                if (is_array($request->get('itemExistCount')))
                {
                    foreach ($request->get('itemExistCount') as $item)
                    {
                        $temp = RequestCommodity::find($item['rcId']);
                        RequestCommodity::where('id' , '=' , $item['rcId'])
                            ->update(['rcExistCount' => $item['existCount'] , 'rcIsExist' => $temp->rcCount <= $item['existCount'] ? true : false]);
                    }

                    // calculate new cost estimation
                    $allRcItems = RequestCommodity::where('rcRId' , '=' , $req->id)->get();
                    if (count($allRcItems) > 0) {
                        $costEstimation = 0;
                        foreach ($allRcItems as $item) {
                            if ($item->rcCount >= $item->rcExistCount) {
                                $costEstimation += (($item->rcCount - $item->rcExistCount) * $item->rcCostEstimation);
                            }
                        }
                        $req->rCostEstimation = $costEstimation;
                        if ($costEstimation == 0) {
                            $req->rRsId = RequestState::where('rsState', '=', 'CLOSED')->value('id');
                            $requestClosed = true;
                        }
                        $req->save();
                    }
                }

                RequestVerifiers::where('rvRId' , '=' , $currentVerifier->rvRId)
                    ->where('rvUId' , '=' , $currentVerifier->rvUId)
                    ->update(['rvSId' => $sig->id]);
                if ($requestClosed)
                {
                    // change request history for current user
                    RequestHistory::where('id' , '=' , $request->lastRefId)
                        ->update(['rhRsId' => $req->rRsId , 'rhDescription' => 'کلیه کالاهای درخواست شده در انبار موجود می باشد، شما می توانید برای دریافت کالا به انبار مراجعه کنید.']);
                }else{
                    $nextVerifier = RequestVerifiers::where('rvRId' , '=' , $currentVerifier->rvRId)
                        ->where('id' , '>' , $currentVerifier->id)
                        ->where('rvSId' , '=' , null)
                        ->first();
                    if ($nextVerifier)
                    {
                        // make history for this request
                        $history = new RequestHistory();
                        $history->rhSrcUId = Auth::user()->id;
                        $history->rhDestUId = $nextVerifier->rvUId; // for secretariat destination
                        $history->rhRId = $currentVerifier->rvRId;
                        $history->rhRsId = $req->rRsId;
                        $history->save();
                    }else{
                        $req->rRsId = RequestState::where('rsState' , '=' , 'SECRETARIAT_QUEUE')->value('id');
                        $req->save();
                        // make history for this request
                        $history = new RequestHistory();
                        $history->rhSrcUId = Auth::user()->id;
                        $history->rhDestUId = null; // for secretariat destination
                        $history->rhRId = $currentVerifier->rvRId;
                        $history->rhRsId = $req->rRsId;
                        $history->save();

                        $srQueue = new SecretariatRequestQueue();
                        $srQueue->srqRId = $currentVerifier->rvRId;
                        $srQueue->save();
                    }
                }

                SystemLog::setFinancialSubSystemLog('تایید درخواست توسط ' . Auth::user()->name);
                return response()->json(
                    $this->getAllReceivedRequests($this->getLastReceivedRequestIdList())
                );

            }else{
                return response()->json([] , 406); //Exist verifiers before you
            }
        }else{
            return response()->json([] , 405);
        }
    }

    public function response(Request $request)
    {
        $rHis = RequestHistory::find($request->lastRefId);
        // make history for this request
        $history = new RequestHistory();
        $history->rhSrcUId = Auth::user()->id;
        $history->rhDestUId = $rHis->rhSrcUId;
        $history->rhRId = $rHis->rhRId;
        $history->rhRsId = $rHis->rhRsId;
        $history->rhIsReferral = true;
        $history->rhDescription = PublicSetting::checkPersianCharacters($request->description);
        $history->save();

        SystemLog::setFinancialSubSystemLog('پاسخ به ارجاع درخواست');

        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList())
        );
    }

    public function numbering(Request $request)
    {
        $req = _Request::find($request->rId);
        $req->rLetterNumber = $request->letterNumber;
        $req->rLetterDate = $request->letterDate;
        $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
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
        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList())
        );
    }

    public function wasSeen(Request $request)
    {
        $rHistory = RequestHistory::find($request->rhId);
        $rHistory->rhHasBeenSeen = true;
        $rHistory->save();

        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList())
        );
    }
}
