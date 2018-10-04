<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayRequest extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_pay_requests';
    protected $appends = [
        'prLastRef' ,
        'prYouAreVerifiers' ,
        'prRemainingVerifiers'
    ];

    public function verifiers()
    {
        return $this->hasMany(PayRequestVerifier::class , 'prvPrId' , 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class , 'prCId' , 'id');
    }

    public function getPrRemainingVerifiersAttribute()
    {
        $myOrder = PayRequestSteps::whereHas('requestVerifiers' , function ($q){
            return $q->where('prvPrId' , '=' , $this->id)
                ->where('prvUId' , '=' , Auth::user()->id);
        })->value('prstOrder');

        if (!$myOrder)
        {
            $result = PayRequestVerifier::where('prvPrId' , '=' , $this->id)
                ->where('prvUId' , '<>' , Auth::user()->id)
                ->where('prvSId' , '=' , null)
                ->with('requestStep')
                ->with('user.role')
                ->get();
        }else{
            $result = PayRequestVerifier::where('prvPrId' , '=' , $this->id)
                ->where('prvUId' , '<>' , Auth::user()->id)
                ->where('prvSId' , '=' , null)
                ->whereHas('requestStep' , function ($q) use($myOrder){
                    return $q->where('prstOrder' , '<' , $myOrder);
                })
                ->with('requestStep')
                ->with('user.role')
                ->get();
        }

        return $result;
    }

    public function getPrYouAreVerifiersAttribute()
    {
        $result = PayRequestVerifier::where('prvPrId' , '=' , $this->id)
            ->where('prvUId' , '=' , Auth::user()->id)
            ->where('prvSId' , '=' , null)
            ->with('requestStep')
            ->get();
        return $result;
    }

    public function getPrLastRefAttribute()
    {
        $lastHistoryId = RequestHistory::where('rhPrId' , '=' , $this->id)->max('id');
        return RequestHistory::with('sourceUserInfo.role.officeUnit')->find($lastHistoryId);
    }
}
