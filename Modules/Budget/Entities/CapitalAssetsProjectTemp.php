<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;

class CapitalAssetsProjectTemp extends Model
{
    protected $table = 'tbl_capital_assets_projects_temp';
    protected $fillable = [];

    public function capitalAssetsApprovedPlan()
    {
        return $this->belongsTo(CapitalAssetsApprovedPlanTemp::class , 'cpCapId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cpCoId' , 'id');
    }

    public function creditSource()
    {
        return $this->hasMany(CapCreditSourceTemp::class , 'ccsCapId' , 'id')->orderBy('id', 'DESC');
    }

}
