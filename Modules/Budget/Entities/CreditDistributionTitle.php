<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;

class CreditDistributionTitle extends Model
{
    protected $table = 'tbl_credit_distribution_titles';
    protected $primaryKey = 'id';
    protected $fillable = ['cdtCdtId' , 'cdtCoId' , 'cdtUId' , 'cdtBsId' , 'cdtIdNumber' , 'cdtSubject' , 'cdtDescription'];

    public function budgetSeason()
    {
        return $this->belongsTo(BudgetSeason::class , 'cdtBsId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cdtCoId' , 'id');
    }

    public function CDTInCounty()
    {
        return $this->hasMany(CreditDistributionTitle::class , 'cdtCdtId' , 'id')->orderBy('id', 'DESC');
    }

    public function creditDistributionPlan()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCdtId' , 'id')->orderBy('id', 'DESC');
    }
}
