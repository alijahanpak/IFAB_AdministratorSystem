<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostAllocation extends Model
{
    protected $table = 'tbl_cost_allocation';
    protected $fillable = [];
    protected $appends = ['caSumOfCost' , 'caConvertedAllocAmount'];

    public function creditSource()
    {
        return $this->belongsTo(CaCreditSource::class , 'caCcsId' , 'id');
    }

    public function getCaSumOfCostAttribute()
    {
        return $this->sumOfCost()->sum('ecAmount');
    }

    public function sumOfCost()
    {
        return $this->hasMany(ExpenseCosts::class , 'ecCaId' , 'id');
    }

    public function getCaConvertedAllocAmountAttribute()
    {
        return $this->hasMany(CostAllocation::class , 'caFoundId' , 'id')->sum('caAmount');
    }
}
