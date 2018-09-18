<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Executor extends Model
{
    protected $fillable = ['eSubject'];
    protected $table = 'tbl_executors';
}
