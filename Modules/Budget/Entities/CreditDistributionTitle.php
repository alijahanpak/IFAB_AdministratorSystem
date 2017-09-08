<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;

class CreditDistributionTitle extends Model
{
    protected $table = 'tbl_credit_distribution_titles';
    protected $fillable = [];

    public function budgetSeason()
    {
        return $this->belongsTo(BudgetSeason::class , 'cdtBsId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cdtCoId' , 'id');
    }
}
