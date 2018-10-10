<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class SubSystem extends Model
{
    protected $table = 'tbl_sub_system';
    protected $fillable = [];

    public function subSystemPart()
    {
        return $this->hasMany(SubSystemPart::class , 'sspSsId' , 'id');
    }
}
