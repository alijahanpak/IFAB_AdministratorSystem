<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class PermissionLimiter extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_permission_limiters';
}
