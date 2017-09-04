<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CdrCap extends Model
{
    protected $table = 'tbl_cdr_cap';
    protected $fillable = [];

    public static function getCapCdrAmount($capId , $cdrId)
    {
        return CdrCap::where('ccCapId' , '=' , $capId)->where('ccCdrId' , '=' , $cdrId)->first()->ccAmount;
    }
}
