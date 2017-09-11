<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsApprovedPlan extends Model
{
    protected $table = 'tbl_capital_assets_approved_plan';
    protected $fillable = [];

    public function creditDistributionTitle()
    {
        return $this->belongsTo(CreditDistributionTitle::class , 'capCdtId' , 'id');
    }

    public static function getTotalAmount($capId)
    {
        return 0;
    }
}
