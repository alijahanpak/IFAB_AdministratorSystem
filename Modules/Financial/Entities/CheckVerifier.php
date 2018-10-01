<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class CheckVerifier extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_check_verifier';

    public function user()
    {
        return $this->belongsTo(User::class , 'cvUId' , 'id')->where('isActive' , '=' , true)->select('id' , 'name' , 'rId' , 'avatarPath' , 'isActive');
    }
}
