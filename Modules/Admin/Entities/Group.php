<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'tbl_groups';
    protected $fillable = [];

    public function userGroup()
    {
        return $this->hasMany(UserGroup::class , 'ugGId' , 'id');
    }
}
