<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapCreditSourceTemp extends Model
{
    protected $table = 'tbl_cap_credit_source_temp';
    protected $fillable = [];
    protected $appends = ['ccsSumOfCost' , 'ccsSumOfReserved' , 'ccsSumOfCommitment' , 'ccsSumOfAllocation'];

    public function creditDistributionRow()
    {
        return $this->belongsTo(CreditDistributionRow::class , 'ccsCdrId' , 'id');
    }

    public function tinySeason()
    {
        return $this->belongsTo(CapitalAssetsTinySeason::class , 'ccsTsId' , 'id');
    }

    public function howToRun()
    {
        return $this->belongsTo(HowToRun::class , 'ccsHtrId' , 'id');
    }

    public function capitalAssetsProject()
    {
        return $this->belongsTo(CapitalAssetsProjectTemp::class , 'ccsCapId' , 'id');
    }

    public function allocation()
    {
        return $this->hasMany(CapitalAssetsAllocation::class , 'caaCcsId' , 'id')->orderBy('id', 'DESC');
    }

    public function getCcsSumOfCostAttribute()
    {
        return $this->allocation()->get()->sum('caaSumOfCost');
    }

    public function getCcsSumOfReservedAttribute()
    {
        return $this->allocation()->get()->sum('caaSumOfReserved');
    }

    public function getCcsSumOfCommitmentAttribute()
    {
        return $this->allocation()->get()->sum('caaSumOfCommitment');
    }

    public function getCcsSumOfAllocationAttribute()
    {
        return $this->allocation()->get()->sum('caaAmount');
    }
}
