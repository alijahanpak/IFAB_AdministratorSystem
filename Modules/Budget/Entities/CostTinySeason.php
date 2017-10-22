<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostTinySeason extends Model
{
    protected $table = 'tbl_cost_tiny_season';
    protected $fillable = [];

    public function seasonTitle()
    {
        return $this->belongsTo(CostSeasonTitle::class , 'ctsCstId' , 'id');
    }

    public static function getTinySeasonWithSId($sId)
    {
        return CostTinySeason::where('catsCastId' , '=' , $sId)->get();
    }
}
