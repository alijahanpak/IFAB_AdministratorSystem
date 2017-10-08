<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostSeasonTitle extends Model
{
    protected $table = 'tbl_cost_season_title';
    protected $fillable = [];

    public function costTinySeason()
    {
        return $this->hasMany(CostTinySeason::class , 'ctsCstId' , 'id');
    }
}
