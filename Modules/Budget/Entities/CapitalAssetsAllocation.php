<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsAllocation extends Model
{
    protected $table = 'tbl_capital_assets_allocation';
    protected $fillable = [];

    public function cdrCaa()
    {
        return $this->hasMany(CdrCaa::class , 'ccCaaId' , 'id');
    }

    public function capitalAssetsProject()
    {
        return $this->belongsTo(CapitalAssetsProject::class , 'caaCpId' , 'id');
    }
}
