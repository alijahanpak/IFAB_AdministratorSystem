<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_roles';
    protected $fillable = [];

    public function rolePermission()
    {
        return $this->hasMany(GroupPermission::class , 'rpRId' , 'id');
    }
}
