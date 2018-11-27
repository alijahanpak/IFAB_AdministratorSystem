<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class _Check extends Model
{
    protected $appends = ['cDelivered' , 'cSpentAmount'];
    protected $fillable = ['cDId' , 'cPdId' , 'cDpId' , 'cAmount' ,'cFyId' , 'cCsId' , 'cFor' , 'cPayTo'];
    protected $table = 'tbl_checks';

    public function percentageDecrease()
    {
        return $this->belongsTo(PercentageDecrease::class , 'cPdId' , 'id');
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class , 'cDpId' , 'id');
    }

    public function draft()
    {
        return $this->belongsTo(Draft::class , 'cDId' , 'id');
    }

    public function checkState()
    {
        return $this->belongsTo(CheckState::class , 'cCsId' , 'id');
    }

    public function printHistory()
    {
        return $this->hasMany(PrintHistory::class , 'phCId' , 'id')->orderBy('id' , 'DESC');
    }

    public function selectedVerifiers()
    {
        return $this->hasMany(SelectedCheckVerifier::class , 'scvCId' , 'id')->orderBy('id');
    }

    public function costSpent()
    {
        return $this->hasMany(CostSpent::class , 'csCId' , 'id');
    }

    public function capSpent()
    {
        return $this->hasMany(CapSpent::class , 'csCId' , 'id');
    }

    public function getCDeliveredAttribute()
    {
        $sumCost = (int)$this->costSpent()->get()->sum('csAmount');
        $sumCost += (int)$this->capSpent()->get()->sum('csAmount');
        if ($sumCost == $this->attributes['cAmount'])
            return true;
        else
            return false;
    }

    public function getCSpentAmountAttribute()
    {
        $sumCost = (int)$this->costSpent()->get()->sum('csAmount');
        $sumCost += (int)$this->capSpent()->get()->sum('csAmount');
        return $sumCost;
    }
}
