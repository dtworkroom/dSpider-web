<?php
/**
 * Created by PhpStorm.
 * User: du
 * Date: 16/12/2
 * Time: 下午3:43
 */

namespace App\Common;


class Utils
{
    static function mergeObject($source, $dest, $overWrite = false) {
        $sourceName = get_class($source);
        foreach ($source as $key => $aProp) {
            if(!$overWrite && isset($dest->$key)) {
                $propName = $sourceName . "_" . $key;
                $dest->$propName = $aProp;
            } else {
                $dest->$key = $aProp;
            }
        }
        return $dest;
    }
    static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }

}