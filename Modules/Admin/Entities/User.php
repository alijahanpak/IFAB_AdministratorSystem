<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [];

    public function inPutAmountUnit()
    {
        return $this->belongsTo(AmountUnit::class , 'seInPutAmount' , 'id');
    }

    public function dispAmountUnit()
    {
        return $this->belongsTo(AmountUnit::class , 'seDispAmount' , 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class , 'rId' , 'id');
    }
}
