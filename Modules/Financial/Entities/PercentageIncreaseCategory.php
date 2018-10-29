<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PercentageIncreaseCategory extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_pi_category';

    public function percentageIncrease()
    {
        return $this->hasMany(PercentageIncrease::class , 'piPicId' , 'id');
    }
}
