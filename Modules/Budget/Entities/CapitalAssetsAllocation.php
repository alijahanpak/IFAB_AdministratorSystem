<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\CapSpent;

class CapitalAssetsAllocation extends Model
{
    protected $table = 'tbl_capital_assets_allocation';
    protected $fillable = [];
    protected $appends = ['caaSumOfCost' , 'caaConvertedAllocAmount'  , 'caaSumOfReserved' , 'caaSumOfCommitment'];

    public function creditSource()
    {
        return $this->belongsTo(CapCreditSource::class , 'caaCcsId' , 'id');
    }

    public function getCaaSumOfCostAttribute()
    {
        $capFinancingIds = CapitalAssetsFinancing::where('cafCaaId' , $this->id)
            ->where('cafDeleted' , false)
            ->pluck('id');
        $sumCapSpent = CapSpent::whereIn('csCafId' , $capFinancingIds)->sum('csAmount');
        return (int)$sumCapSpent;
    }

    public function sumOfReserve()
    {
        return $this->hasMany(CapitalAssetsFinancing::class , 'cafCaaId' , 'id')
            ->where('cafDeleted' , '=' , false)
            ->where('cafAccepted' , '=' , false);
    }

    public function sumOfCommitment()
    {
        return $this->hasMany(CapitalAssetsFinancing::class , 'cafCaaId' , 'id')
            ->where('cafDeleted' , '=' , false)
            ->where('cafAccepted' , '=' , true);
    }

    public function getCaaConvertedAllocAmountAttribute()
    {
        return $this->hasMany(CapitalAssetsAllocation::class , 'caaFoundId' , 'id')->sum('caaAmount');
    }

    public function getCaaSumOfReservedAttribute()
    {
        return $this->sumOfReserve()->sum('cafAmount');
    }

    public function getCaaSumOfCommitmentAttribute()
    {
        return $this->sumOfCommitment()->sum('cafAmount');
    }
}
