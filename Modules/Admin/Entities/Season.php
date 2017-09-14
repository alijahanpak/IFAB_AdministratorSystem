<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\TinySeason;

class Season extends Model
{
    protected $table = 'tbl_seasons';
    protected $fillable = [];

    public function tinySeason()
    {
        return $this->hasMany(TinySeason::class , 'tsSId' , 'id');
    }
}
