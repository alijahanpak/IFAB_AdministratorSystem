<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Category;

class RequestStep extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_request_steps';

    public function requestType()
    {
        return $this->belongsTo(RequestType::class , 'rstRtId' , 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'rstCId' , 'id');
    }

    public function requestVerifiers()
    {
        return $this->hasMany(RequestVerifiers::class , 'rvRstId' , 'id');
    }
}
