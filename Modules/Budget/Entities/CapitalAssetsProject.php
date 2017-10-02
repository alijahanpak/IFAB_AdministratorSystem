<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsProject extends Model
{
    protected $table = 'tbl_capital_assets_projects';
    protected $fillable = [];

    public function capitalAssetsApprovedPlan()
    {
        return $this->belongsTo(CapitalAssetsApprovedPlan::class , 'cpCapId' , 'id');
    }

    public function howToRun()
    {
        return $this->belongsTo(HowToRun::class , 'cpHtrId' , 'id');
    }

    public function tinySeason()
    {
        return $this->belongsTo(TinySeason::class , 'cpTsId' , 'id');
    }

    public function cdrCp()
    {
        return $this->hasMany(CdrCp::class , 'ccCpId' , 'id');
    }

    public function capitalAssetsAllocation()
    {
        return $this->hasMany(CapitalAssetsAllocation::class , 'caaCpId' , 'id');
    }

}
