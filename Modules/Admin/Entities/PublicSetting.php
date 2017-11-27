<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class PublicSetting extends Model
{
    protected $table = 'tbl_public_setting';
    protected $fillable = [];

    public static function getProvincePlanLebel()
    {
        return PublicSetting::first()->psProvincePlanLabel;
    }

    public static function checkPersianCharacters($text)
    {
        if(is_null($text))
            return null;
        $replacePairs = array(
            chr(0xD9).chr(0xA0) => chr(0xDB).chr(0xB0),
            chr(0xD9).chr(0xA1) => chr(0xDB).chr(0xB1),
            chr(0xD9).chr(0xA2) => chr(0xDB).chr(0xB2),
            chr(0xD9).chr(0xA3) => chr(0xDB).chr(0xB3),
            chr(0xD9).chr(0xA4) => chr(0xDB).chr(0xB4),
            chr(0xD9).chr(0xA5) => chr(0xDB).chr(0xB5),
            chr(0xD9).chr(0xA6) => chr(0xDB).chr(0xB6),
            chr(0xD9).chr(0xA7) => chr(0xDB).chr(0xB7),
            chr(0xD9).chr(0xA8) => chr(0xDB).chr(0xB8),
            chr(0xD9).chr(0xA9) => chr(0xDB).chr(0xB9),
            chr(0xD9).chr(0x83) => chr(0xDA).chr(0xA9),
            chr(0xD9).chr(0x89) => chr(0xDB).chr(0x8C),
            chr(0xD9).chr(0x8A) => chr(0xDB).chr(0x8C),
            chr(0xDB).chr(0x80) => chr(0xD9).chr(0x87) . chr(0xD9).chr(0x94));
        return strtr($text, $replacePairs);
    }
}
