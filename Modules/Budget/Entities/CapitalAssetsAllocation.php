<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsAllocation extends Model
{
    protected $table = 'tbl_capital_assets_allocation';
    protected $fillable = [];
    protected $appends = ['caaSumOfCost' , 'caaConvertedAllocAmount'];

/*    public function cdrCaa()
    {
        return $this->hasMany(CdrCaa::class , 'ccCaaId' , 'id');
    }*/

    public function creditSource()
    {
        return $this->belongsTo(CapCreditSource::class , 'caaCcsId' , 'id');
    }

    public function getCaaSumOfCostAttribute()
    {
        return $this->sumOfCost()->sum('cacAmount');
    }

    public function sumOfCost()
    {
        return $this->hasMany(CapitalAssetsCost::class , 'cacCaaId' , 'id');
    }

    public function getCaaConvertedAllocAmountAttribute()
    {
        return $this->hasMany(CapitalAssetsAllocation::class , 'caaFoundId' , 'id')->sum('caaAmount');
    }
}
