<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\User;

class _Request extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_requests';
    protected $appends = ['rLastRef' , 'rYouAreVerifiers' , 'rRemainingVerifiers' , 'rCreditIsAccepted' , 'rCreditIsExist' , 'rAcceptedAmount'];

    public function requestState()
    {
        return $this->belongsTo(RequestState::class , 'rRsId' , 'id');
    }

    public function requestType()
    {
        return $this->belongsTo(RequestType::class , 'rRtId' , 'id');
    }

    public function requestCommodity()
    {
        return $this->hasMany(RequestCommodity::class , 'rcRId' , 'id')->orderBy('id', 'DESC');
    }

    public function contract()
    {
        return $this->hasMany(Contract::class , 'cRId' , 'id')->orderBy('id', 'DESC');
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
        $amount = Contract::where('cRId' , '=' , $this->id)->sum('cAmount');
        $amount += Factor::where('fRId' , '=' , $this->id)->sum('fAmount');

        return $amount;
    }

    public function getRLastRefAttribute()
    {
        $lastHistoryId = RequestHistory::where('rhRId' , '=' , $this->id)->max('id');
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
}
