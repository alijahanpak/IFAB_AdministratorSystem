<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class PayRequestVerifier extends Model
{
    protected $fillable = ['prvSId' , 'prvPrstId' , 'prvPrId' , 'prvUId'];
    protected $table = 'tbl_pay_request_verifiers';

    public function user()
    {
        return $this->belongsTo(User::class , 'prvUId' , 'id')->select('id' , 'name' , 'rId' , 'avatarPath');
    }

    public function requestStep()
    {
        return $this->belongsTo(PayRequestSteps::class , 'prvPrstId' , 'id');
    }
}
