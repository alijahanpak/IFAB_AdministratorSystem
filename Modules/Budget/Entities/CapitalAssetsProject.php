<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;

class CapitalAssetsProject extends Model
{
    protected $table = 'tbl_capital_assets_projects';
    protected $fillable = [];
    protected $appends = ['cpSumOfCost' , 'cpSumOfReserved' , 'cpSumOfFinancing' , 'cpSumOfCommitment'];

    public function capitalAssetsApprovedPlan()
    {
        return $this->belongsTo(CapitalAssetsApprovedPlan::class , 'cpCapId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cpCoId' , 'id');
    }

    public function creditSource()
    {
        return $this->hasMany(CapCreditSource::class , 'ccsCapId' , 'id')->orderBy('id', 'DESC');
    }

    public function creditSourceHasAllocation()
    {
        return $this->hasMany(CapCreditSource::class , 'ccsCapId' , 'id')->has('allocation')->orderBy('id', 'DESC');
    }

    public function getCpSumOfCostAttribute()
    {
        return $this->creditSource()->get()->sum('ccsSumOfCost');
    }

    public function getCpSumOfReservedAttribute()
    {
        return $this->creditSource()->get()->sum('ccsSumOfReserved');
    }

    public function getCpSumOfFinancingAttribute()
    {
        return $this->creditSource()->get()->sum('ccsSumOfFinancing');
    }

    public function getCpSumOfCommitmentAttribute()
    {
        return $this->creditSource()->get()->sum('ccsSumOfCommitment');
    }
}
