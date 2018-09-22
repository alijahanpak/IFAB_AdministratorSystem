<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = ['sSubject'];
    protected $table = 'tbl_sellers';

}
