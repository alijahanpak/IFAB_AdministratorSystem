<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CostAllocation;

class CostFinancing extends Model
{
    protected $fillable = ['cfCaId' , 'cfRId' , 'cfAmount' , 'cfAccepted'];
    protected $table = 'tbl_cost_financing';

    public function allocation()
    {
        return $this->belongsTo(CostAllocation::class , 'cfCaId' , 'id');
    }
}
