<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class PayRequest extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_pay_requests';
}
