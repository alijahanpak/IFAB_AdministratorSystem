<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostAllocation;

class CostFinancing extends Model
{
    protected $fillable = ['cfCaId' , 'cfRId' , 'cfAmount' , 'cfAccepted' , 'cfSpent' , 'cfRemainingAmount'];
    protected $table = 'tbl_cost_financing';

    public function allocation()
    {
        return $this->belongsTo(CostAllocation::class , 'cfCaId' , 'id');
    }

    public function getCfSpentAttribute()
    {
        return CostSpent::where('csCfId' , $this->id)->get()->sum('csAmount');
    }

    public function getCfRemainingAmountAttribute()
    {
        return $this->attributes['cfAmount'] - $this->getCfSpentAttribute();
    }
}
