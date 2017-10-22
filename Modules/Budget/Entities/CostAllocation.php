<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostAllocation extends Model
{
    protected $table = 'tbl_cost_allocation';
    protected $fillable = [];

    public function cdrCaa()
    {
        return $this->hasMany(CdrCaa::class , 'ccCaaId' , 'id');
    }

    public function creditSource()
    {
        return $this->belongsTo(CaCreditSource::class , 'caaCcsId' , 'id');
    }
}
