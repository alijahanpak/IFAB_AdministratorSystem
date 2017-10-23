<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class BudgetSeason extends Model
{
    protected $table = 'tbl_budget_seasons';
    protected $fillable = [];

    public function creditDistributionPlanTitle()
    {
        return $this->hasMany(CreditDistributionTitle::class , 'cdtBsId' , 'id');
    }

    public function cdpTitleHasCreditDistributionPlan()
    {
        return $this->hasMany(CreditDistributionTitle::class , 'cdtBsId' , 'id')->has('creditDistributionPlan');
    }
}
