<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\DeprivedArea;

class County extends Model
{
    protected $table = 'tbl_counties';
    protected $fillable = [];

    public function creditDistributionPlan()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCoId' , 'id');
    }
}
