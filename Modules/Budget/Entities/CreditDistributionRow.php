<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CreditDistributionRow extends Model
{
    protected $table = 'tbl_credit_distribution_rows';
    protected $fillable = [];

    public function creditDistributionPlan()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCdrId' , 'id');
    }
}
