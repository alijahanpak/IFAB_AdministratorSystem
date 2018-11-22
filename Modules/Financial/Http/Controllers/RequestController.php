<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\RoleCategory;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\UserPermission;
use Modules\Budget\Entities\CostAllocation;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\AccountantRequestQueue;
use Modules\Financial\Entities\Attachment;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\Commodity;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\FinancialRequestQueue;
use Modules\Financial\Entities\RequestCommodity;
use Modules\Financial\Entities\RequestHistory;
use Modules\Financial\Entities\RequestHistoryLastPoint;
use Modules\Financial\Entities\RequestLevel;
use Modules\Financial\Entities\RequestState;
use Modules\Financial\Entities\RequestStep;
use Modules\Financial\Entities\RequestType;
use Modules\Financial\Entities\RequestVerifiers;
use Modules\Financial\Entities\SecretariatRequestQueue;
use Modules\Financial\Entities\SupplierRequestQueue;
use Modules\Financial\Entities\UnitOfContractRequestQueue;

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
        })->where(function ($q) use($userCat){
            return $q->whereHas('category' , function ($query) use($userCat){
                return $query->whereNotIn('id' , $userCat);
            })->orWhere('rstIsRequire' , false);
        })
            ->where('rstOrder' , '<>' , 1)
            ->with(['category.roleCategory.role.user' => function($q){
                return $q->where('isActive' , '=' , true);
            }])
            ->orderBy('rstOrder')
            ->get();
        return \response()->json($rType);
    }

    function fetchPostedRequestsData(Request $request)
    {
        $req = $this->getAllPostedRequests(Auth::user()->id , $request->searchValue);
        return \response()->json($req);
    }

    function getAllPostedRequests($uId , $searchValue)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return _Request::where('rUId' , '=' , $uId)
            ->where('rFyId' , '=' , Auth::user()->seFiscalYear)
            ->where(function ($q) use($searchValue){
                return $q->where('rSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rCostEstimation' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rDescription' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rFurtherDetails' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rLetterNumber' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rLetterDate' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhereHas('requestState' , function($q) use($searchValue){
                        return $q->where('rsSubject' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->orWhereHas('requestType' , function($q) use($searchValue){
                        return $q->where('rtSubject' , 'LIKE' , '%' . $searchValue . '%');
                    });
            })
            ->with('requestState')
            ->with('requestType')
            ->with('attachment')
            ->with('verifiers.user.role.officeUnit')
            ->with('requestCommodity.commodity')
            ->with('history.sourceUserInfo.role')
            ->with('history.destinationUserInfo.role')
            ->with('history.requestState')
            ->with('contract.executor')
            ->with('contract.increaseAmount.percentageIncrease')
            ->with('factor.seller')
            ->with('factor.factorState')
            ->with(['draft' => function($q){
                return $q->whereHas('verifier' , function ($q1){
                    return $q1->where('dvSId' ,'<>' , null);
                })->with('verifier.user.role')
                    ->with('verifier.signature')
                    ->with('check.percentageDecrease');
            }])
            ->with('payRequest.payRequestState')
            ->with('requestLevel')
            ->with('refundFactor.factor.factorState')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
    }

    function update(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $req = _Request::find($request->id);
            if ($request->resultType == 'POSTED')
            {
                if ($req->rAllowUpdateInPosted == false)
                    return \response()->json($this->getAllPostedRequests(Auth::user()->id , $request->searchValue) , 400);
            }else if ($request->resultType == 'RECEIVED')
            {
                if ($req->rAllowUpdateInReceived == false)
                    return \response()->json($this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue) , 400);
            }
            $req->rSubject = PublicSetting::checkPersianCharacters($request->subject);
            $req->rCostEstimation = $request->costEstimation;
            $req->rDescription = PublicSetting::checkPersianCharacters($request->description);
            $req->rFurtherDetails = PublicSetting::checkPersianCharacters($request->furtherDetails);
            $req->save();

            if (is_array($request->get('items')))
            {
                $i =0;
                $reqCommodityIds = [];
                foreach ($request->get('items') as $item)
                {
                    $cId = Commodity::firstOrCreate(['cSubject' => PublicSetting::checkPersianCharacters(trim($item['commodityName']))]);
                    $reqCom = RequestCommodity::updateOrCreate(['rcRId' => $req->id , 'rcCId' => $cId->id],[
                        'rcCount' => $item['commodityCount'],
                        'rcCostEstimation' => $item['commodityPrice'],
                        'rcDescription' => PublicSetting::checkPersianCharacters($item['commodityDescription'])
                    ]);
                    $reqCommodityIds[$i++] = $reqCom->id;
                }

                if (count($reqCommodityIds) > 0)
                {
                    RequestCommodity::whereNotIn('id' , $reqCommodityIds)
                        ->where('rcRId' , $req->id)
                        ->delete();
                }
            }

            SystemLog::setFinancialSubSystemLog('تغییر درخواست ' . $req->rSubject);
            if ($request->resultType == 'POSTED')
            {
                return \response()->json($this->getAllPostedRequests(Auth::user()->id , $request->searchValue));
            }else if ($request->resultType == 'RECEIVED')
            {
                return \response()->json($this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue));
            }
        });

        return $result;
    }

    function register(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $req = new _Request();
            $req->rRsId = RequestState::where('rsState' , '=' , 'ACTIVE')->value('id');
            $req->rRtId = $request->rtId;
            $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'REQUEST')->value('id');
            $req->rUId = Auth::user()->id;
            $req->rFyId = Auth::user()->seFiscalYear;
            $req->rSubject = PublicSetting::checkPersianCharacters($request->subject);
            $req->rCostEstimation = $request->costEstimation;
            $req->rDescription = PublicSetting::checkPersianCharacters($request->description);
            $req->rFurtherDetails = PublicSetting::checkPersianCharacters($request->furtherDetails);
            $req->save();

            if ($request->exists('attachments'))
            {
                foreach ($request->file('attachments') as $files)
                {
                    $fileName = $files->store('attachments');
                    $attachment = new Attachment();
                    $attachment->aRId = $req->id;
                    $attachment->aPath = $fileName;
                    $attachment->aName = $files->getClientOriginalName();
                    $attachment->aSize = $files->getClientSize();
                    $attachment->save();
                }
            }

            if (is_array($request->get('items')))
            {
                foreach ($request->get('items') as $item)
                {
                    $cId = Commodity::firstOrCreate(['cSubject' => PublicSetting::checkPersianCharacters(trim($item['subject']))]);
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
                throw new \Exception(500);

            $userCat = RoleCategory::where('rcRId' , '=' , Auth::user()->rId)->pluck('rcCId');
            $mySteps = RequestStep::where('rstRtId' , '=' , $request->rtId)
                ->whereIn('rstCId' , $userCat)
                ->orderBy('rstOrder')
                ->get();

            $firstStepId = RequestStep::where('rstRtId' , '=' , $request->rtId)
                ->orderBy('rstOrder')
                ->first();

            $selectedStepsId = array();
            if (is_array($request->get('verifiers'))) {
                foreach ($request->get('verifiers') as $verifiers){
                    $selectedStepsId[] = $verifiers['rstId'];
                }
            }

            RequestVerifiers::firstOrCreate(['rvSId' => $userSig->id , 'rvRstId' => $firstStepId->id , 'rvRId' => $req->id , 'rvUId' => Auth::user()->id]);
            foreach ($mySteps as $myStep)
            {
                if (!in_array($myStep->id , $selectedStepsId) && $myStep->rstIsRequire == true)
                    RequestVerifiers::firstOrCreate(['rvSId' => $userSig->id , 'rvRstId' => $myStep->id , 'rvRId' => $req->id , 'rvUId' => Auth::user()->id]);
                else if (in_array($myStep->id , $selectedStepsId) && $myStep->rstIsRequire == false)
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

            $reqType = RequestType::find($request->rtId);
            SystemLog::setFinancialSubSystemLog('ثبت درخواست ' . $reqType->rtSubject);

            return \response()->json($this->getAllPostedRequests(Auth::user()->id , $request->searchValue));
        });

        return $result;

    }

    function addNewAttachments(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if ($request->exists('attachments'))
            {
                foreach ($request->file('attachments') as $files)
                {
                    try{
                        $fileName = $files->store('attachments');
                        $attachment = new Attachment();
                        $attachment->aRId = $request->rId;
                        $attachment->aPath = $fileName;
                        $attachment->aName = $files->getClientOriginalName();
                        $attachment->aSize = $files->getClientSize();
                        $attachment->save();
                    }catch (Exception $e){
                        throw new \Exception(500);
                    }
                }

                return \response()->json($this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue));
            }
        });

        return $result;
    }

    function deleteAttachment(Request $request)
    {
        $storagePath = Config::get('filesystems.disks.local.root');
        $result = DB::transaction(function () use($request , $storagePath){
            $attachment = Attachment::find($request->id);
            Attachment::where('id' , '=' , $request->id)
                ->delete();
            @unlink($storagePath . '/' . $attachment->aPath);

            return \response()->json(
                $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }

    function fetchReceivedRequestsData(Request $request)
    {
        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
        );
    }

    function getAllReceivedRequests($reqIds , $searchValue)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        $requestLevels = RequestLevel::all();
        $result = [];
        $allowRequestStates = RequestState::where('rsState' , '=' , 'ACTIVE')
            ->orWhere('rsState' , '=' , 'WAITING_REVIEW')
            ->pluck('id');
        foreach ($requestLevels as $level)
        {
            $result[$level->rlLevel] = _Request::whereIn('id' , $reqIds)
                ->whereIn('rRsId' , $allowRequestStates)
                ->where('rRlId' , '=' , $level->id)
                ->where('rFyId' , '=' , Auth::user()->seFiscalYear)
                ->where(function ($q) use($searchValue){
                    return $q->where('rSubject' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('rCostEstimation' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('rDescription' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('rFurtherDetails' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('rLetterNumber' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('rLetterDate' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhereHas('requestState' , function($q) use($searchValue){
                            return $q->where('rsSubject' , 'LIKE' , '%' . $searchValue . '%');
                        })
                        ->orWhereHas('requestType' , function($q) use($searchValue){
                            return $q->where('rtSubject' , 'LIKE' , '%' . $searchValue . '%');
                        });
                })
                ->with('requestState')
                ->with('requestType')
                ->with('verifiers.user.role.officeUnit')
                ->with(['requestCommodity' => function($q){
                    return $q->where('rcIsExist' , '=' , 0)
                        ->with('commodity');
                }])
                ->with('attachment')
                ->with('history.sourceUserInfo.role')
                ->with('history.destinationUserInfo.role')
                ->with('history.requestState')
                ->with('contract.executor')
                ->with('contract.increaseAmount')
                ->with('factor.seller')
                ->with('factor.factorState')
                ->with('factor.refundFactor')
                ->with('draft.verifier.user.role')
                ->with('draft.check.percentageDecrease')
                ->with('draft.check.checkState')
                ->with('draft.draftState')
                ->with('payRequest.payRequestState')
                ->with('payRequest.verifiers.user.role.officeUnit')
                ->with('payRequest.verifiers.signature')
                ->with('payRequest.contract.executor')
                ->with('requestHistoryLastPoint')
                ->with('requestLevel')
                ->with('payRequest.draft')
                ->with('refundFactor')
                ->with('contract.increaseAmount.percentageIncrease')
                ->orderBy('id' , 'DESC')
                ->paginate(20);
        }

        return $result;
    }

    function getUnReadReceivedRequestCount(Request $request)
    {
        return RequestHistory::where('rhDestUId' , '=' , Auth::user()->id)
            ->where('rhHasBeenSeen' , '=' , 0)
            ->whereHas('request' , function ($q){
                return $q->where('rFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->count();
    }

    function normalSearch(Request $request)
    {
        $searchValue = PublicSetting::checkPersianCharacters($request->searchValue);
        $result = _Request::where(function ($q) use($searchValue){
                return $q->where('rSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rDescription' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rLetterNumber' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rLetterDate' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('rCostEstimation' , '=' , $searchValue)
                    ->orWhereHas('creator' , function ($query) use($searchValue){
                        return $query->where('name' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->orWhereHas('requestType' , function ($query) use($searchValue){
                        return $query->where('rtSubject' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->orWhereHas('requestState' , function ($query) use($searchValue){
                        return $query->where('rsSubject' , 'LIKE' , '%' . $searchValue . '%');
                    });
            })
            ->where('rFyId' , '=' , Auth::user()->seFiscalYear)
            ->with('requestState')
            ->with('requestType')
            ->with('requestCommodity.commodity')
            ->with('history.sourceUserInfo.role')
            ->with('history.destinationUserInfo.role')
            ->with('history.requestState')
            ->with(['draft' => function($q){
                return $q->whereHas('verifier' , function ($q1){
                    return $q1->where('dvSId' ,'<>' , null);
                })->with('verifier.user.role')
                    ->with('verifier.signature')
                    ->with('check.percentageDecrease');
            }])
            ->with('attachment')
            ->with('contract.executor')
            ->with('contract.increaseAmount')
            ->with('factor.seller')
            ->with('factor.factorState')
            ->with('draft.verifier.user.role')
            ->with('draft.check.percentageDecrease')
            ->with('draft.check.checkState')
            ->with('draft.draftState')
            ->orderBy('id' , 'DESC')
            ->paginate(20);
        return response()->json($result);
    }

    public function referral(Request $request)
    {
        $result = DB::transaction(function () use($request){
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
            $history->rhDId = $request->dId;
            $history->rhPrId = $request->prId;
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
                $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }

    public function getLastReceivedRequestIdList()
    {
        /////////// check access to secretariat queue permission //////////////////////
        $accessToSQPermission = UserPermission::where('upUId' , '=' , Auth::user()->id)
            ->whereHas('permission' , function ($q){
                return $q->where('pPermission' , '=' , 'SECRETARIAT_QUEUE_DISPLAY');
            })
            ->count();
        if ($accessToSQPermission)
        {
            DB::transaction(function (){
                $secQueue = SecretariatRequestQueue::all()->pluck('srqRId');
                RequestHistory::whereIn('rhRId' , $secQueue)
                    ->where('rhRsId' , '=' , RequestState::where('rsState' , '=' , 'SECRETARIAT_QUEUE')->value('id'))
                    ->update(['rhDestUId' => Auth::user()->id , 'rhRsId' => RequestState::where('rsState' , '=' , 'ACTIVE')->value('id')]);
                _Request::whereIn('id' , $secQueue)->update(['rRsId' => RequestState::where('rsState' , '=' , 'ACTIVE')->value('id')]);
                SecretariatRequestQueue::whereIn('srqRId' , $secQueue)->delete();
            });
        }

        /////////// check access to financing queue permission //////////////////////
        $accessToFQPermission = UserPermission::where('upUId' , '=' , Auth::user()->id)
            ->whereHas('permission' , function ($q){
                return $q->where('pPermission' , '=' , 'FINANCIAL_QUEUE_DISPLAY');
            })
            ->count();
        if ($accessToFQPermission)
        {
            DB::transaction(function () {
                $finQueue = FinancialRequestQueue::all()->pluck('frqRId');
                RequestHistory::whereIn('rhRId', $finQueue)
                    ->where('rhRsId', '=', RequestState::where('rsState', '=', 'FINANCIAL_QUEUE')->value('id'))
                    ->update(['rhDestUId' => Auth::user()->id, 'rhRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                _Request::whereIn('id', $finQueue)->update(['rRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                FinancialRequestQueue::whereIn('frqRId', $finQueue)->delete();
            });
        }

        /////////// check access to supplier queue permission //////////////////////
        $accessToSPQPermission = UserPermission::where('upUId' , '=' , Auth::user()->id)
            ->whereHas('permission' , function ($q){
                return $q->where('pPermission' , '=' , 'SUPPLIER_QUEUE_DISPLAY');
            })
            ->count();
        if ($accessToSPQPermission)
        {
            DB::transaction(function () {
                $finQueue = SupplierRequestQueue::all()->pluck('srqRId');
                RequestHistory::whereIn('rhRId', $finQueue)
                    ->where('rhRsId', '=', RequestState::where('rsState', '=', 'SUPPLIER_QUEUE')->value('id'))
                    ->update(['rhDestUId' => Auth::user()->id, 'rhRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                _Request::whereIn('id', $finQueue)->update(['rRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                SupplierRequestQueue::whereIn('srqRId', $finQueue)->delete();
            });
        }

        /////////// check access to unit of contract queue permission //////////////////////
        $accessToNFCQPermission = UserPermission::where('upUId' , '=' , Auth::user()->id)
            ->whereHas('permission' , function ($q){
                return $q->where('pPermission' , '=' , 'UNIT_OF_CONTRACT_QUEUE_DISPLAY');
            })
            ->count();
        if ($accessToNFCQPermission)
        {
            DB::transaction(function () {
                $finQueue = UnitOfContractRequestQueue::all()->pluck('ufcrqRId');
                RequestHistory::whereIn('rhRId', $finQueue)
                    ->where('rhRsId', '=', RequestState::where('rsState', '=', 'UNIT_OF_CONTRACT_QUEUE')->value('id'))
                    ->update(['rhDestUId' => Auth::user()->id, 'rhRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                _Request::whereIn('id', $finQueue)->update(['rRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                UnitOfContractRequestQueue::whereIn('ufcrqRId', $finQueue)->delete();
            });
        }

        /////////// check access to accountant queue permission //////////////////////
        $accessToAQPermission = UserPermission::where('upUId' , '=' , Auth::user()->id)
            ->whereHas('permission' , function ($q){
                return $q->where('pPermission' , '=' , 'ACCOUNTANT_QUEUE_DISPLAY');
            })
            ->count();
        if ($accessToAQPermission)
        {
            DB::transaction(function () {
                $accQueue = AccountantRequestQueue::all()->pluck('arqRId');
                RequestHistory::whereIn('rhRId', $accQueue)
                    ->where('rhRsId', '=', RequestState::where('rsState', '=', 'ACCOUNTANT_QUEUE')->value('id'))
                    ->update(['rhDestUId' => Auth::user()->id, 'rhRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                _Request::whereIn('id', $accQueue)->update(['rRsId' => RequestState::where('rsState', '=', 'ACTIVE')->value('id')]);
                AccountantRequestQueue::whereIn('arqRId', $accQueue)->delete();
            });
        }
        //////////////////////////////////////////////////////////////////////////////////////
        $rhIds = RequestHistory::selectRaw('rhRId , MAX(id) as id')
            ->groupBy('rhRId')
            ->pluck('id');

        $req = RequestHistory::whereIn('id' , $rhIds)
            ->where('rhDestUId' , '=' , Auth::user()->id)
            ->where('rhRsId' , '<>' , RequestState::where('rsState' , '=' , 'WAITING_FOR_PAY_REQUEST')->value('id'))
            ->orderBy('id' , 'DESC')
            ->pluck('rhRId');
        return $req;
    }

    public function accept(Request $request)
    {
        $sig = Signature::where('sUId' , '=' , Auth::user()->id)->first();
        $currentVerifier = RequestVerifiers::find($request->verifierId);
        $req = _Request::find($currentVerifier->rvRId);

        if ($currentVerifier->rvUId == Auth::user()->id)
        {
            if (count($req->rRemainingVerifiers) == 0)
            {
                $result = DB::transaction(function () use($request , $req , $currentVerifier , $sig){
                    $requestClosed = false;
                    // determine exist item with warehouse keeper
                    if (is_array($request->get('itemExistCount')) && count($request->get('itemExistCount')) > 0)
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
                                if ($item->rcCount > $item->rcExistCount) {
                                    $costEstimation += (($item->rcCount - $item->rcExistCount) * ($item->rcCostEstimation / $item->rcCount));
                                    RequestCommodity::where('id' , '=' , $item->id)
                                        ->update(['rcCostEstimation' => (($item->rcCount - $item->rcExistCount) * ($item->rcCostEstimation / $item->rcCount))]);
                                }else if ($item->rcCount == $item->rcExistCount)
                                {
                                    RequestCommodity::where('id' , '=' , $item->id)
                                        ->update(['rcCostEstimation' => 0]);
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
                        $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
                    );
                });

                return $result;

            }else{
                return response()->json([] , 406); //Exist verifiers before you
            }
        }else{
            return response()->json([] , 405);
        }
    }

    public function response(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $rHis = RequestHistory::find($request->lastRefId);
            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = $rHis->rhSrcUId;
            $history->rhRId = $rHis->rhRId;
            $history->rhRsId = $rHis->rhRsId;
            $history->rhDId = $request->dId;
            $history->rhPrId = $request->prId;
            $history->rhIsReferral = true;
            $history->rhDescription = PublicSetting::checkPersianCharacters($request->description);
            $history->save();

            SystemLog::setFinancialSubSystemLog('پاسخ به ارجاع درخواست');

            return \response()->json(
                $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });
        return $result;

    }

    public function numbering(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $req = _Request::find($request->rId);
            $req->rLetterNumber = $request->letterNumber;
            $req->rLetterDate = $request->letterDate;
            $req->rRsId = RequestState::where('rsState' , '=' , 'FINANCIAL_QUEUE')->value('id');
            $req->rRlId = RequestLevel::where('rlLevel' , '=' , 'FINANCIAL')->value('id');
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
                $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }

    public function wasSeen(Request $request)
    {
        $rHistory = RequestHistory::find($request->rhId);
        $rHistory->rhHasBeenSeen = true;
        $rHistory->save();

        return \response()->json(
            $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
        );
    }

    public function block(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $req = _Request::find($request->rId);
            $req->rRsId = RequestState::where('rsState' , '=' , 'BLOCKED')->value('id');
            $req->save();

            CostFinancing::where('cfRId' , '=' , $req->id)->update(['cfDeleted' => true]);
            CapitalAssetsFinancing::where('cafRId' , '=' , $req->id)->update(['cafDeleted' => true]);

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = Auth::user()->id; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhHasBeenSeen = true;
            $history->rhDescription = PublicSetting::checkPersianCharacters($request->description);
            $history->save();

            RequestHistoryLastPoint::where('rhlpRId' , '=' , $request->rId)->delete();

            SystemLog::setFinancialSubSystemLog('مسدود کردن درخواست با عنوان ' . $req->rSubject);
            return \response()->json(
                $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }

    public function terminate(Request $request)
    {
        $result = DB::transaction(function () use($request){
            $req = _Request::find($request->rId);
            $req->rRsId = RequestState::where('rsState' , '=' , 'CLOSED')->value('id');
            $req->save();

            // make history for this request
            $history = new RequestHistory();
            $history->rhSrcUId = Auth::user()->id;
            $history->rhDestUId = Auth::user()->id; // for accountant destination
            $history->rhRId = $req->id;
            $history->rhRsId = $req->rRsId;
            $history->rhHasBeenSeen = true;
            $history->rhDescription = PublicSetting::checkPersianCharacters($request->description);
            $history->save();

            SystemLog::setFinancialSubSystemLog('خاتمه دادن به درخواست ' . $req->rSubject);

            return \response()->json(
                $this->getAllReceivedRequests($this->getLastReceivedRequestIdList() , $request->searchValue)
            );
        });

        return $result;
    }
}
