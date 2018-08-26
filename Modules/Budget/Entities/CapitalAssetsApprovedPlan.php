<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsApprovedPlan extends Model
{
    protected $table = 'tbl_capital_assets_approved_plan';
    protected $fillable = [];
    protected $appends = ['capSumOfCost' , 'capSumOfReserved' , 'capSumOfFinancing' , 'capSumOfCommitment'];

    public function creditDistributionTitle()
    {
        return $this->belongsTo(CreditDistributionTitle::class , 'capCdtId' , 'id');
    }

    public function capitalAssetsProject()
    {
        return $this->hasMany(CapitalAssetsProject::class , 'cpCapId' , 'id')->orderBy('id', 'DESC');
    }

    public function capitalAssetsProjectHasCreditSource()
    {
        return $this->hasMany(CapitalAssetsProject::class , 'cpCapId' , 'id')->has('creditSourceHasAllocation')->orderBy('id', 'DESC');
    }

    public static function getTotalAmount($capId)
    {
        return 0;
    }

    public function amendments()
    {
        return $this->hasMany(CapitalAssetsApprovedPlan::class , 'capCapId' , 'id')->orderBy('id', 'DESC');
    }

    public function getCapSumOfCostAttribute()
    {
        return $this->capitalAssetsProject()->get()->sum('cpSumOfCost');
    }

    public function getCapSumOfReservedAttribute()
    {
        return $this->capitalAssetsProject()->get()->sum('cpSumOfReserved');
    }

    public function getCapSumOfFinancingAttribute()
    {
        return $this->capitalAssetsProject()->get()->sum('cpSumOfFinancing');
    }

    public function getCapSumOfCommitmentAttribute()
    {
        return $this->capitalAssetsProject()->get()->sum('cpSumOfCommitment');
    }
}
