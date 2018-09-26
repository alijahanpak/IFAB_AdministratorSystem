<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\User;

class DraftVerifier extends Model
{
    protected $fillable = ['dvSId'];
    protected $table = 'tbl_draft_verifiers';

    public function user()
    {
        return $this->belongsTo(User::class , 'dvUId' , 'id')->select('id' , 'name' , 'rId' , 'avatarPath');
    }

    public function signature()
    {
        return $this->belongsTo(Signature::class , 'dvSId' , 'id');
    }
}
