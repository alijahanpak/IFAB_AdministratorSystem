<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CaCreditSource extends Model
{
    protected $table = 'tbl_ca_credit_source';
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

    public function costAgreement()
    {
        return $this->belongsTo(CostAgreement::class , 'ccsCaId' , 'id');
    }

    public function allocation()
    {
        return $this->hasMany(CostAllocation::class , 'caCcsId' , 'id');
    }
}
