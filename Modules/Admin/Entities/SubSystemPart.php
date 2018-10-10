<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class SubSystemPart extends Model
{
    protected $table = 'tbl_sub_system_parts';
    protected $fillable = [];

    public function permission()
    {
        return $this->hasMany(Permission::class , 'pSspId' , 'id');
    }
}
