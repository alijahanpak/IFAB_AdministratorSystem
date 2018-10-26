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
        $amountUnit = User::where('id' , Auth::user()->id)
            ->with('inPutAmountUnit')
            ->first();
        return $amount * $amountUnit->inPutAmountUnit->auAmount;
    }

    public static function convertDispAmount($amount)
    {
        $amountUnit = User::where('id' , Auth::user()->id)
            ->with('inPutAmountUnit')
            ->first();
        $tempAmount = ($amount / ($amountUnit->dispAmountUnit->auAmount));
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
        $amountUnit = User::where('id' , Auth::user()->id)
            ->with('inPutAmountUnit')
            ->first();
        return ($amount / ($amountUnit->dispAmountUnit->auAmount));
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
