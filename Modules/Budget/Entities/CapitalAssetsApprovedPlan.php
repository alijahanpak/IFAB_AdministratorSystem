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

    public function capitalAssetsProject()
    {
        return $this->hasMany(CapitalAssetsProject::class , 'cpCapId' , 'id')->has('creditSource');
    }

    public static function getTotalAmount($capId)
    {
        return 0;
    }
}
