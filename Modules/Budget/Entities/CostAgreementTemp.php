<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostAgreementTemp extends Model
{
    protected $table = 'tbl_cost_agreement_temp';
    protected $fillable = [];
    protected $appends = ['caSumOfCost' , 'caSumOfReserved' , 'caSumOfCommitment' , 'caSumOfAllocation'];

    public function caCreditSource()
    {
        return $this->hasMany(CaCreditSourceTemp::class , 'ccsCaId' , 'id')->orderBy('id', 'DESC');
    }

    public function caCreditSourceHasAllocation()
    {
        return $this->hasMany(CaCreditSourceTemp::class , 'ccsCaId' , 'id')->has('allocation')->orderBy('id', 'DESC');
    }

    public function getCaSumOfCostAttribute()
    {
        return $this->caCreditSourceHasAllocation()->get()->sum('ccsSumOfCost');
    }

    public function getCaSumOfReservedAttribute()
    {
        return $this->caCreditSourceHasAllocation()->get()->sum('ccsSumOfReserved');
    }

    public function getCaSumOfCommitmentAttribute()
    {
        return $this->caCreditSourceHasAllocation()->get()->sum('ccsSumOfCommitment');
    }

    public function getCaSumOfAllocationAttribute()
    {
        return $this->caCreditSourceHasAllocation()->get()->sum('ccsSumOfAllocation');
    }
}
