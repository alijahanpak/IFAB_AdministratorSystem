<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PayRequestState extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_pay_request_states';
}
