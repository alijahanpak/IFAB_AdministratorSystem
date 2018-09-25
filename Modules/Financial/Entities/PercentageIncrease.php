<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PercentageIncrease extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_percentage_increases';
    protected $appends = ['piRealPercent'];

    public function getPiRealPercentAttribute()
    {
        $decrease = PercentageDecrease::find($this->id);
        if ($decrease)
            return $this->attributes['piPercent'] + $decrease->pdPercent;
        else
            return $this->attributes['piPercent'];
    }
}
