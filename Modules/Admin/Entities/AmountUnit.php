<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AmountUnit extends Model
{
    protected $table = 'tbl_amount_units';
    protected $fillable = [];

    public static function convertInputAmount($amount)
    {
        $amountUnit = (User::find(Auth::user()->id)->first()->inPutAmountUnit->auAmount);
        return $amount * $amountUnit;
    }

    public static function convertDispAmount($amount)
    {
        $tempAmount = ($amount / (User::where('id' , '=' , Auth::user()->id)->first()->dispAmountUnit->auAmount));
        $numberAr = explode('.', (string)$tempAmount);
        if(isset($numberAr[1]))
        {
            $count = strlen($numberAr[1]);
        }
        else
        {
            $count = 0;
        }
        return number_format ( $tempAmount , $count , "." , "," );
    }

    public static function convertDispAmountWithoutSplliter($amount)
    {
        $tempAmount = ($amount / (User::where('id' , '=' , Auth::user()->id)->first()->dispAmountUnit->auAmount));
        return $tempAmount;
    }

    public function userInPutAmountUnit()
    {
        return $this->hasMany(User::class , 'seInPutAmount' , 'id');
    }

    public function userDispAmountUnit()
    {
        return $this->hasMany(User::class , 'seDispAmount' , 'id');
    }
}
