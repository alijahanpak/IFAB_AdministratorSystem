<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_categories';

    public function roleCategory()
    {
        return $this->hasMany(RoleCategory::class ,'rcCId' , 'id');
    }
}
