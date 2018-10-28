<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PercentageDecreaseCategory extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_pd_category';

    public function percentageDecrease()
    {
        return $this->hasMany(PercentageDecrease::class , 'pdPdcId' , 'id');
    }
}
