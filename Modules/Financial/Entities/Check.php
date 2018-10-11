<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class _Check extends Model
{
    protected $appends = ['cDeliveryShamsiDate' , 'cDeliveryShamsiTime'];
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
        if ($this->attributes['cDelivered'] == true)
            return jDate::forge($this->updated_at)->format('Y/m/d');
        else
            return '';
    }

    public function getCDeliveryShamsiTimeAttribute()
    {
        if ($this->attributes['cDelivered'] == true)
            return jDate::forge($this->updated_at)->format('time');
        else
            return '';
    }
}
