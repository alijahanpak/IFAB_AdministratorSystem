<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;

class CapitalAssetsProject extends Model
{
    protected $table = 'tbl_capital_assets_projects';
    protected $fillable = [];

    public function capitalAssetsApprovedPlan()
    {
        return $this->belongsTo(CapitalAssetsApprovedPlan::class , 'cpCapId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cpCoId' , 'id');
    }

    public function creditSource()
    {
        return $this->hasMany(CapCreditSource::class , 'ccsCapId' , 'id');
    }
}
