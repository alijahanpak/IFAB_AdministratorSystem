<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Season;

class CapitalAssetsSeasonTitle extends Model
{
    protected $table = 'tbl_capital_assets_season_title';
    protected $fillable = [];

    public function capitalAssetsTinySeason()
    {
        return $this->hasMany(CapitalAssetsTinySeason::class , 'catsCastId' , 'id')->orderBy('id', 'DESC');
    }

    public function season()
    {
        return $this->belongsTo(Season::class , 'castSId' , 'id');
    }
}
