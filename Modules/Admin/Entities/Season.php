<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;
use Modules\Budget\Entities\CapitalAssetsTinySeason;
use Modules\Budget\Entities\CostSeasonTitle;

class Season extends Model
{
    protected $table = 'tbl_seasons';
    protected $fillable = [];

    public function capitalAssetsSeasonTitle()
    {
        return $this->hasMany(CapitalAssetsSeasonTitle::class , 'castSId' , 'id')->has('capitalAssetsTinySeason');
    }

    public function costSeasonTitle()
    {
        return $this->hasMany(CostSeasonTitle::class , 'cstSId' , 'id')->has('costTinySeason');
    }
}
