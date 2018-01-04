<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'tbl_role_permissions';
    protected $fillable = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class , 'rpPId' , 'id');
    }
}