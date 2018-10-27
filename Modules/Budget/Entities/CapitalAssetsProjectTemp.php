<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;

class CapitalAssetsProjectTemp extends Model
{
    protected $table = 'tbl_capital_assets_projects_temp';
    protected $fillable = [];
    protected $appends = ['cpSumOfCost' , 'cpSumOfReserved' , 'cpSumOfCommitment' , 'cpSumOfAllocation'];

    public function capitalAssetsApprovedPlan()
    {
        return $this->belongsTo(CapitalAssetsApprovedPlanTemp::class , 'cpCapId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cpCoId' , 'id');
    }

    public function creditSource()
    {
        return $this->hasMany(CapCreditSourceTemp::class , 'ccsCapId' , 'id')->orderBy('id', 'DESC');
    }

    public function creditSourceHasAllocation()
    {
        return $this->hasMany(CapCreditSourceTemp::class , 'ccsCapId' , 'id')->has('allocation')->orderBy('id', 'DESC');
    }

    public function getCpSumOfCostAttribute()
    {
        return $this->creditSourceHasAllocation()->get()->sum('ccsSumOfCost');
    }

    public function getCpSumOfReservedAttribute()
    {
        return $this->creditSourceHasAllocation()->get()->sum('ccsSumOfReserved');
    }

    public function getCpSumOfCommitmentAttribute()
    {
        return $this->creditSourceHasAllocation()->get()->sum('ccsSumOfCommitment');
    }

    public function getCpSumOfAllocationAttribute()
    {
        return $this->creditSourceHasAllocation()->get()->sum('ccsSumOfAllocation');
    }

}
