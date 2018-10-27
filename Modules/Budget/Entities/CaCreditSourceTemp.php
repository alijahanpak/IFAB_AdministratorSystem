<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CaCreditSourceTemp extends Model
{
    protected $table = 'tbl_ca_credit_source_temp';
    protected $fillable = [];
    protected $appends = ['ccsSumOfCost' , 'ccsSumOfReserved' , 'ccsSumOfCommitment' , 'ccsSumOfAllocation'];

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

    public function allocation()
    {
        return $this->hasMany(CostAllocation::class , 'caCcsId' , 'id')->orderBy('id', 'DESC');
    }

    public function getCcsSumOfCostAttribute()
    {
        return $this->allocation()->get()->sum('caSumOfCost');
    }

    public function getCcsSumOfReservedAttribute()
    {
        return $this->allocation()->get()->sum('caSumOfReserved');
    }

    public function getCcsSumOfCommitmentAttribute()
    {
        return $this->allocation()->get()->sum('caSumOfCommitment');
    }

    public function getCcsSumOfAllocationAttribute()
    {
        return $this->allocation()->get()->sum('caAmount');
    }
}
