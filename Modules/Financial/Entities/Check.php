<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class _Check extends Model
{
    protected $appends = ['cDeliveryShamsiDate' , 'cDeliveryShamsiTime' , 'cDelivered'];
    protected $fillable = ['cDId' , 'cPdId' , 'cAmount' ,'cFyId'];
    protected $table = 'tbl_checks';

    public function percentageDecrease()
    {
        return $this->belongsTo(PercentageDecrease::class , 'cPdId' , 'id');
    }

    public function draft()
    {
        return $this->belongsTo(Draft::class , 'cDId' , 'id');
    }

    public function getCDeliveryShamsiDateAttribute()
    {
        if ($this->getCDeliveredAttribute() == true)
            return jDate::forge($this->updated_at)->format('Y/m/d');
        else
            return '';
    }

    public function getCDeliveryShamsiTimeAttribute()
    {
        if ($this->getCDeliveredAttribute() == true)
            return jDate::forge($this->updated_at)->format('time');
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
}
