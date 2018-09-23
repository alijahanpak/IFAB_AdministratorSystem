<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PercentageDecrease extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_percentage_decreases';
    protected $appends = ['pdPercent'];

    public function percentageIncrease()
    {
        return $this->belongsTo(PercentageIncrease::class , 'pdPiId' , 'id');
    }

    public function getPdPercentAttribute()
    {
        $increaseValue = PercentageIncrease::find($this->attributes['pdPiId']);
        if ($increaseValue)
            return $this->attributes['pdPercent'] + $increaseValue->piPercent;
        else
            return $this->attributes['pdPercent'];
    }
}
