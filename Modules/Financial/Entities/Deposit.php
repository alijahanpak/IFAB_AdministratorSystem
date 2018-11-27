<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = ['dDpId' , 'dDrId' , 'dDsId' , 'dAmount'];
    protected $table = 'tbl_deposits';

    public function depositPercentage()
    {
        return $this->belongsTo(DepositPercentage::class , 'dDpId' , 'id');
    }
}
