<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Financial\Entities\CostFinancing;

class CostAllocation extends Model
{
    protected $table = 'tbl_cost_allocation';
    protected $fillable = [];
    protected $appends = ['caSumOfCost' , 'caConvertedAllocAmount' , 'caSumOfReserved' , 'caSumOfFinancing' , 'caSumOfCommitment'];

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

    public function sumOfReserve()
    {
        return $this->hasMany(CostFinancing::class , 'cfCaId' , 'id')->where('cfAccepted' , '=' , false);
    }

    public function sumOfFinancing()
    {
        return $this->hasMany(CostFinancing::class , 'cfCaId' , 'id')->where('cfAccepted' , '=' , true);
    }

    public function getCaConvertedAllocAmountAttribute()
    {
        return $this->hasMany(CostAllocation::class , 'caFoundId' , 'id')->sum('caAmount');
    }

    public function getCaSumOfReservedAttribute()
    {
        return $this->sumOfReserve()->sum('cfAmount');
    }

    public function getCaSumOfFinancingAttribute()
    {
        return $this->sumOfFinancing()->sum('cfAmount');
    }

    public function getCaSumOfCommitmentAttribute()
    {
        return 0;
    }
}
