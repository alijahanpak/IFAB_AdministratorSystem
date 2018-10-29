<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class IncreaseContractAmount extends Model
{
    protected $fillable = ['icaAmount' , 'icaCId' , 'icaPiId'];
    protected $table = 'tbl_increase_contract_amount';

    public function percentageIncrease()
    {
        return $this->belongsTo(PercentageIncrease::class , 'icaPiId' , 'id');
    }
}
