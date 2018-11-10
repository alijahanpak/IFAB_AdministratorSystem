<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class DepositPercentageCategory extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_deposit_percentage_category';

    public function depositPercentage()
    {
        return $this->hasMany(DepositPercentage::class , 'dpDpcId' , 'id');
    }
}
