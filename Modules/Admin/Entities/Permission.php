<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\PermissionLimiter;

class Permission extends Model
{
    protected $table = 'tbl_permissions';
    protected $fillable = [];
    protected $appends = ['pFyLimiterState'];

    public function getPFyLimiterStateAttribute()
    {
        return PermissionLimiter::where('plFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('plPId' , '=' , $this->id)->exists();
    }
}
