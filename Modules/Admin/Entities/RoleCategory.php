<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleCategory extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_role_categories';

    public function role()
    {
        return $this->belongsTo(Role::class ,'rcRId' , 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class ,'rcCId' , 'id');
    }
}
