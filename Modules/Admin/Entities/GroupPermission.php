<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class GroupPermission extends Model
{
    protected $table = 'tbl_group_permissions';
    protected $fillable = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class , 'rpPId' , 'id');
    }
}
