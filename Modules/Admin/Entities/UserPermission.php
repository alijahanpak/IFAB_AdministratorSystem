<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_user_permissions';

    public function permission()
    {
        return $this->belongsTo(Permission::class , 'upPId' , 'id');
    }
}
