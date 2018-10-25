<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostAllocation;

class CostFinancing extends Model
{
    protected $fillable = ['cfCaId' , 'cfRId' , 'cfAmount' , 'cfAccepted'];
    protected $appends = ['cfSpent' , 'cfRemainingAmount'];
    protected $table = 'tbl_cost_financing';

    public function allocation()
    {
        return $this->belongsTo(CostAllocation::class , 'cfCaId' , 'id');
    }

    public function request()
    {
        return $this->belongsTo(_Request::class , 'cfRId' , 'id');
    }

    public function spent()
    {
        return $this->hasMany(CostSpent::class , 'csCfId' , 'id');
    }

    public function getCfSpentAttribute()
    {
        return $this->spent()->sum('csAmount');
    }

    public function getCfRemainingAmountAttribute()
    {
        return $this->attributes['cfAmount'] - $this->getCfSpentAttribute();
    }
}
