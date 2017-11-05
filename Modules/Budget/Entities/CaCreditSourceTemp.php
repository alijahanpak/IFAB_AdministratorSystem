<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CaCreditSourceTemp extends Model
{
    protected $table = 'tbl_ca_credit_source_temp';
    protected $fillable = [];

    public function tinySeason()
    {
        return $this->belongsTo(CostTinySeason::class , 'ccsTsId' , 'id');
    }

    public function creditDistributionRow()
    {
        return $this->belongsTo(CreditDistributionRow::class , 'ccsCdrId' , 'id');
    }

    public function creditDistributionTitle()
    {
        return $this->belongsTo(CreditDistributionTitle::class , 'ccsCdtId' , 'id');
    }
}
