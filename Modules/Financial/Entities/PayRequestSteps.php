<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Category;

class PayRequestSteps extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_pay_request_steps';

    public function category()
    {
        return $this->belongsTo(Category::class , 'prstCId' , 'id');
    }

    public function requestVerifiers()
    {
        return $this->hasMany(PayRequestVerifier::class , 'prvPrstId' , 'id');
    }
}
