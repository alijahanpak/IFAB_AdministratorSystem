<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PayRequestVerifier extends Model
{
    protected $fillable = ['prvSId' , 'prvPrstId' , 'prvPrId' , 'prvUId'];
    protected $table = 'tbl_pay_request_verifiers';
}
