<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\User;

class _Request extends Model
{
    protected $fillable = ['rRlId'];
    protected $table = 'tbl_requests';
    protected $appends = ['rLastRef' ,
        'rFirstRef' ,
        'rYouAreVerifiers' ,
        'rRemainingVerifiers' ,
        'rCreditIsAccepted' ,
        'rCreditIsExist' ,
        'rAcceptedAmount' ,
        'rCommitmentAmount' ,
        'rSumOfDraftAmount' ,
        'rSumOfDraftPureAmount' ,
        'rSumOfFactorAmount' ,
        'rIsPaid',
        'rIsPayRequestClosed',
        'rRelativeFactor' ,
        'rFinalSpent',
        'rAllowUpdateInPosted',
        'rAllowUpdateInReceived'];

    public function requestState()
    {
        return $this->belongsTo(RequestState::class , 'rRsId' , 'id');
    }

    public function requestHistoryLastPoint()
    {
        return $this->hasMany(RequestHistoryLastPoint::class , 'rhlpRId' , 'id');
    }

    public function requestLevel()
    {
        return $this->belongsTo(RequestLevel::class , 'rRlId' , 'id');
    }

    public function requestType()
    {
        return $this->belongsTo(RequestType::class , 'rRtId' , 'id');
    }

    public function requestCommodity()
    {
        return $this->hasMany(RequestCommodity::class , 'rcRId' , 'id')->orderBy('id', 'DESC');
    }

    public function draft()
    {
        return $this->hasMany(Draft::class , 'dRId' , 'id')->orderBy('id', 'DESC');
    }

    public function payRequest()
    {
        return $this->hasMany(PayRequest::class , 'prRId' , 'id')->orderBy('id', 'DESC');
    }

    public function contract()
    {
        return $this->hasMany(Contract::class , 'cRId' , 'id')->orderBy('id', 'DESC');
    }

    public function factor()
    {
        return $this->hasMany(Factor::class , 'fRId' , 'id')->orderBy('id', 'DESC');
    }

    public function refundFactor()
    {
        return $this->hasMany(RefundFactor::class , 'rfRId' , 'id')->orderBy('id', 'DESC');
    }

    public function attachment()
    {
        return $this->hasMany(Attachment::class , 'aRId' , 'id')->orderBy('id', 'DESC');
    }

    public function history()
    {
        return $this->hasMany(RequestHistory::class , 'rhRId' , 'id')->orderBy('id' , 'DESC');
    }

    public function verifiers()
    {
        return $this->hasMany(RequestVerifiers::class , 'rvRId' , 'id');
    }

    public function getRCreditIsAcceptedAttribute()
    {
        $costFinancingState = CostFinancing::where('cfRId' , '=' , $this->id)
            ->where('cfAccepted' , '=' , false)
            ->exists();
        $capFinancingState = CapitalAssetsFinancing::where('cafRId' , '=' , $this->id)
            ->where('cafAccepted' , '=' , false)
            ->exists();

        return (!$capFinancingState) && (!$costFinancingState);
    }

    public function getRCreditIsExistAttribute()
    {
        $cfExist = CostFinancing::where('cfRId' , '=' , $this->id)->exists();
        $cafExist = CapitalAssetsFinancing::where('cafRId' , '=' , $this->id)->exists();

        return $cfExist || $cafExist;
    }

    public function getRAcceptedAmountAttribute()
    {
        if (RequestType::find($this->attributes['rRtId'])->rtType == 'BUY_SERVICES' ||
            RequestType::find($this->attributes['rRtId'])->rtType == 'BUY_COMMODITY')
        {
            $amount = Contract::where('cRId' , '=' , $this->id)
                ->where('cIsAccepted' , true)->get()->sum('cAmount');
            $amount += Factor::where('fRId' , '=' , $this->id)
                ->where('fFsId' , FactorState::where('fsState' , 'ACCEPTED')->value('id'))->get()->sum('fAmount');
            return $amount;
        }else{
            return $this->getRCommitmentAmountAttribute();
        }
    }

    public function getRCommitmentAmountAttribute()
    {
        $costAmount = CostFinancing::where('cfRId' , $this->id)
            ->where('cfAccepted' , true)
            ->sum('cfAmount');

        $capAmount = CapitalAssetsFinancing::where('cafRId' , $this->id)
            ->where('cafAccepted' , true)
            ->sum('cafAmount');

        return $costAmount + $capAmount;
    }

    public function getRLastRefAttribute()
    {
        $lastHistoryId = RequestHistory::where('rhRId' , '=' , $this->id)->max('id');
        return RequestHistory::with('sourceUserInfo.role.officeUnit')->find($lastHistoryId);
    }

    public function getRFirstRefAttribute()
    {
        $lastHistoryId = RequestHistory::where('rhRId' , '=' , $this->id)->min('id');
        return RequestHistory::with('sourceUserInfo.role.officeUnit')->find($lastHistoryId);
    }

    public function getRYouAreVerifiersAttribute()
    {
        $result = RequestVerifiers::where('rvRId' , '=' , $this->id)
            ->where('rvUId' , '=' , Auth::user()->id)
            ->where('rvSId' , '=' , null)
            ->with('requestStep')
            ->get();
        return $result;
    }

    public function getRRemainingVerifiersAttribute()
    {
        $myOrder = RequestStep::whereHas('requestVerifiers' , function ($q){
            return $q->where('rvRId' , '=' , $this->id)
                ->where('rvUId' , '=' , Auth::user()->id);
        })->value('rstOrder');

        if (!$myOrder)
        {
            $result = RequestVerifiers::where('rvRId' , '=' , $this->id)
                ->where('rvUId' , '<>' , Auth::user()->id)
                ->where('rvSId' , '=' , null)
                ->with('requestStep')
                ->with('user.role')
                ->get();
        }else{
            $result = RequestVerifiers::where('rvRId' , '=' , $this->id)
                ->where('rvUId' , '<>' , Auth::user()->id)
                ->where('rvSId' , '=' , null)
                ->whereHas('requestStep' , function ($q) use($myOrder){
                    return $q->where('rstOrder' , '<' , $myOrder);
                })
                ->with('requestStep')
                ->with('user.role')
                ->get();
        }

        return $result;
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'rUId' , 'id')->select('name');
    }

    public function getRSumOfDraftAmountAttribute()
    {
        $sum = Draft::where('dRId' , '=' , $this->id)
            ->where('dDsId' , '<>' , DraftState::where('dsState' , '=' , 'BLOCKED')->value('id'))->sum('dAmount');
        return $sum;
    }

    public function getRSumOfDraftPureAmountAttribute()
    {
        $sum = Draft::where('dRId' , '=' , $this->id)
            ->where('dDsId' , '<>' , DraftState::where('dsState' , '=' , 'BLOCKED')->value('id'))->sum('dPureAmount');
        return $sum;
    }

    public function getRSumOfFactorAmountAttribute()
    {
        $sum = Factor::where('fRId' , '=' , $this->id)
            ->where('fFsId' , '<>' , FactorState::where('fsState' , '=' , 'NOT_ACCEPTED')->value('id'))->sum('fAmount');

        $factors = RefundFactor::where('rfRId' , $this->id)->pluck('rfFId');
        $sum += Factor::whereIn('id' , $factors)
            ->where('fFsId' , '<>' , FactorState::where('fsState' , '=' , 'NOT_ACCEPTED')->value('id'))->sum('fAmount');
        return $sum;
    }

    public function getRIsPaidAttribute()
    {
        $draftsId = Draft::where('dRId' , '=' , $this->id)->pluck('id');
        $sumOfChecksAmount = _Check::whereIn('cDId' , $draftsId)
            ->get()
            ->where('cCsId' , '=' , CheckState::where('csState' , 'DELIVERED')->value('id'))
            ->sum('cAmount');
        if (count($draftsId) == 0)
            return false;
        else
            return $sumOfChecksAmount < $this->getRCommitmentAmountAttribute() ? false : true;
    }

    public function getRIsPayRequestClosedAttribute()
    {
        return PayRequest::where('prRId' , '=' , $this->id)
            ->where('prPrsId' , '<>' , PayRequestState::where('prsState' , '=' , 'BLOCKED')->value('id'))
            ->where('prIsFinal' , '=' , true)
            ->exists();
    }

    public function getRRelativeFactorAttribute()
    {
        return Factor::whereHas('refundFactor' , function ($q){
                return $q->where('rfRId' , $this->id);
            })
            ->with('refundFactor')
            ->with('request')
            ->with('factorState')
            ->with('seller')
            ->get();
    }

    public function getRFinalSpentAttribute()
    {
        $checkIds = _Check::whereHas('draft' , function ($q){
                return $q->where('dRId' , $this->id);
            })->pluck('id');
        $sumAmount = CostSpent::whereIn('csCId' , $checkIds)->sum('csAmount');
        $sumAmount += CapSpent::whereIn('csCId' , $checkIds)->sum('csAmount');
        return (int)$sumAmount;
    }

    public function getRAllowUpdateInPostedAttribute()
    {
        $rHistory = RequestHistory::where('rhRId' , $this->id)->orderBy('id')->first();
        return $rHistory->rhHasBeenSeen == true ? false : true;
    }

    public function getRAllowUpdateInReceivedAttribute()
    {
        if (RequestVerifiers::where('rvRId' , $this->id)->where('rvUId' , Auth::user()->id)->exists())
        {
            $nextStep = RequestStep::whereIn('id' , RequestVerifiers::where('rvRId' , $this->id)->pluck('rvRstId'))
                ->where('rstOrder' , '>' , RequestStep::where('id' , RequestVerifiers::where('rvUId' , Auth::user()->id)->where('rvRId' , $this->id)->value('rvRstId'))->value('rstOrder'))
                ->where('rstRtId' , $this->rRtId)
                ->orderBy('rstOrder')
                ->first();

            if ($nextStep)
            {
                return RequestVerifiers::where('rvRId' , $this->id)
                    ->where('rvRstId' , $nextStep->id)
                    ->where('rvSId' , null)
                    ->exists();
            }else{
                return RequestVerifiers::where('rvUId' , Auth::user()->id)
                    ->where('rvRId' , $this->id)
                    ->where('rvSId' , null)
                    ->exists();
            }
        }else{
            return false;
        }
    }
}
