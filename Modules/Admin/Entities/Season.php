<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsTinySeason;

class Season extends Model
{
    protected $table = 'tbl_seasons';
    protected $fillable = [];

    public function tinySeason()
    {
        return $this->hasMany(CapitalAssetsTinySeason::class , 'tsSId' , 'id');
    }
}
