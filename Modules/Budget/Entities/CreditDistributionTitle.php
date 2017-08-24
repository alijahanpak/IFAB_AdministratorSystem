<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CreditDistributionTitle extends Model
{
    protected $table = 'tbl_credit_distribution_titles';
    protected $fillable = [];

    public function budgetSeason()
    {
        return $this->belongsTo(BudgetSeason::class , 'cdtBsId' , 'id');
    }
}
