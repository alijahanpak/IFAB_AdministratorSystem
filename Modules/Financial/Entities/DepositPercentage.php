<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class DepositPercentage extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_deposit_percentages';
    protected $appends = ['dpSumOfPercents'];

    public function getDpSumOfPercentsAttribute()
    {
        return $this->dpTemporaryPayPercent + $this->dpDefinativePayPercent;
    }
}
