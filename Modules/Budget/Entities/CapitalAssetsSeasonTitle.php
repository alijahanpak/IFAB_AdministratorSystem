<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsSeasonTitle extends Model
{
    protected $table = 'tbl_capital_assets_season_title';
    protected $fillable = [];

    public function capitalAssetsTinySeason()
    {
        return $this->hasMany(CapitalAssetsTinySeason::class , 'catsCastId' , 'id');
    }
}
