<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class RefundFactor extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_refund_factors';

    public function factor()
    {
        return $this->belongsTo(Factor::class , 'rfFId' , 'id');
    }
}
