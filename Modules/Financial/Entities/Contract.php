<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['cIsAccepted'];
    protected $table = 'tbl_contracts';
    protected $appends = ['cAmount' , 'cAmountWithIncOrDec'];

    public function executor()
    {
        return $this->belongsTo(Executor::class , 'cEId' , 'id');
    }

    public function increaseAmount()
    {
        return $this->hasMany(IncreaseContractAmount::class , 'icaCId' , 'id');
    }

    function getCAmountAttribute()
    {
        $finalPayRequest = PayRequest::where('prCId' , '=' , $this->id)
            ->where('prPrsId' , '<>' , PayRequestState::where('prsState' , '=' , 'BLOCKED')->value('id'))
            ->where('prLetterNumber' , '<>' , null)
            ->where('prLetterDate' , '<>' , null)
            ->where('prIsFinal' , '=' , true)
            ->first();
        $increases = IncreaseContractAmount::where('icaCId' , '=' , $this->id)
            ->with('percentageIncrease')
            ->get();
        if ($finalPayRequest)
        {
            if ($finalPayRequest->prAmountProgress > 100)
            {
                $incPercent = $finalPayRequest->prAmountProgress - 100;
                $baseAmount = round($this->cBaseAmount * (($incPercent / 100) + 1));

                $amount = $baseAmount;
                foreach ($increases as $increase)
                {
                    $amount += round($baseAmount * ($increase['percentageIncrease']['piPercent'] / 100));
                }

                return $amount;
            }else if ($finalPayRequest->prAmountProgress < 100){
                $incPercent = 100 - $finalPayRequest->prAmountProgress;
                $baseAmount = $this->cBaseAmount - round($this->cBaseAmount * ($incPercent / 100));

                $amount = $baseAmount;
                foreach ($increases as $increase)
                {
                    $amount += round($baseAmount * ($increase['percentageIncrease']['piPercent'] / 100));
                }

                return $amount;
            }
        }

        $sumIncreases = IncreaseContractAmount::where('icaCId' , '=' , $this->id)->get()->sum('icaAmount');
        return $sumIncreases + $this->cBaseAmount;
    }

    function getCAmountWithIncOrDecAttribute()
    {
        $finalPayRequest = PayRequest::where('prCId' , '=' , $this->id)
            ->where('prPrsId' , '<>' , PayRequestState::where('prsState' , '=' , 'BLOCKED')->value('id'))
            ->where('prIsFinal' , '=' , true)
            ->first();
        if ($finalPayRequest)
        {
            if ($finalPayRequest->prAmountProgress > 100)
            {
                $incPercent = $finalPayRequest->prAmountProgress - 100;
                $baseAmount = round($this->cBaseAmount * (($incPercent / 100) + 1));
                return $baseAmount;
            }else if ($finalPayRequest->prAmountProgress < 100){
                $incPercent = 100 - $finalPayRequest->prAmountProgress;
                $baseAmount = $this->cBaseAmount - round($this->cBaseAmount * ($incPercent / 100));
                return $baseAmount;
            }
        }
        return $this->cBaseAmount;
    }
}
