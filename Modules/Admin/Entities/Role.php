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

    public function officeUnit()
    {
        return $this->belongsTo(OfficeUnite::class , 'rOuId' , 'id');
    }

    public function user()
    {
        return $this->hasMany(User::class , 'rId' , 'id')->select('id' , 'rId' , 'name' , 'avatarPath');
    }

    public function category()
    {
        return $this->hasMany(RoleCategory::class , 'rcRId' , 'id');
    }
}
