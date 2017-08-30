<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Season;

class TinySeason extends Model
{
    protected $table = 'tbl_tiny_seasons';
    protected $fillable = [];

    public function season()
    {
        return $this->belongsTo(Season::class , 'tsSId' , 'id');
    }

    public static function getTinySeasonWithSId($sId)
    {
        return TinySeason::where('tsSId' , '=' , $sId)->get();
    }
}
