<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class CostSpent extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_cost_spents';

    public function check()
    {
        return $this->belongsTo(_Check::class , 'csCId' , 'id');
    }
}
