<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class ProvincialBudgetProposal extends Model
{
    protected $table = 'tbl_provincial_budget_proposals';
    protected $fillable = [];

    public function creditDistributionPlan()
    {
        return $this->belongsTo(CreditDistributionPlan::class , 'pbpCdpId' , 'id');
    }
}
