<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class _Check extends Model
{
    protected $appends = ['cDeliveryShamsiDate' , 'cDeliveryShamsiTime' , 'cDelivered' , 'cSpentAmount'];
    protected $fillable = ['cDId' , 'cPdId' , 'cAmount' ,'cFyId' , 'cCsId'];
    protected $table = 'tbl_checks';

    public function percentageDecrease()
    {
        return $this->belongsTo(PercentageDecrease::class , 'cPdId' , 'id');
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

    public function getCDeliveryShamsiDateAttribute()
    {
        if ($this->getCDeliveredAttribute() == true)
            return jDate::forge($this->attributes['cDeliveryDate'])->format('Y/m/d');
        else
            return '';
    }

    public function getCDeliveryShamsiTimeAttribute()
    {
        if ($this->getCDeliveredAttribute() == true)
            return jDate::forge($this->attributes['cDeliveryDate'])->format('time');
        else
            return '';
    }

    public function getCDeliveredAttribute()
    {
        $sumCost = CostSpent::where('csCId' , '=' , $this->id)->get()->sum('csAmount');
        $sumCost += CapSpent::where('csCId' , '=' , $this->id)->get()->sum('csAmount');
        if ($sumCost == $this->attributes['cAmount'])
            return true;
        else
            return false;
    }

    public function getCSpentAmountAttribute()
    {
        $sumCost = CostSpent::where('csCId' , '=' , $this->id)->get()->sum('csAmount');
        $sumCost += CapSpent::where('csCId' , '=' , $this->id)->get()->sum('csAmount');
        return $sumCost;
    }
}
