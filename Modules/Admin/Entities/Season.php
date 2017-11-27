<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;
use Modules\Budget\Entities\CapitalAssetsTinySeason;
use Modules\Budget\Entities\CostAllocation;
use Modules\Budget\Entities\CostSeasonTitle;
use Modules\Budget\Entities\CostTinySeason;

class Season extends Model
{
    protected $table = 'tbl_seasons';
    protected $fillable = [];

    public function capitalAssetsSeasonTitle()
    {
        return $this->hasMany(CapitalAssetsSeasonTitle::class , 'castSId' , 'id');
    }

    public function capitalAssetsSeasonTitleHasTinySeason()
    {
        return $this->hasMany(CapitalAssetsSeasonTitle::class , 'castSId' , 'id')->has('capitalAssetsTinySeason');
    }

    public function costSeasonTitle()
    {
        return $this->hasMany(CostSeasonTitle::class , 'cstSId' , 'id');
    }

    public function costSeasonTitleHasTinySeason()
    {
        return $this->hasMany(CostSeasonTitle::class , 'cstSId' , 'id')->has('costTinySeason');
    }
}
