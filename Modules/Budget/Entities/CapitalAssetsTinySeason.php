<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Season;

class CapitalAssetsTinySeason extends Model
{
    protected $table = 'tbl_capital_assets_tiny_seasons';
    protected $fillable = [];

    public function seasonTitle()
    {
        return $this->belongsTo(CapitalAssetsSeasonTitle::class , 'catsCastId' , 'id');
    }

    public static function getTinySeasonWithSId($sId)
    {
        return CapitalAssetsTinySeason::where('catsCastId' , '=' , $sId)->get();
    }
}
