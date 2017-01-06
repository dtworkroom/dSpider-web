<?php
/**
 * Created by PhpStorm.
 * User: du
 * Date: 16/12/2
 * Time: 下午3:43
 */

function mergeObject($dest, $source, $overWrite = true)
{
//        $sourceName = get_class($source);
    foreach ($source as $key => $aProp) {
        if (!$overWrite && isset($dest->$key)) {
//                $propName = $sourceName . "_" . $key;
//                $dest->$propName = $aProp;
            continue;
        } else {
            $dest->$key = $aProp;
        }
    }
    return $dest;
}

function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

function qs($array){
   return ['qs'=>$array] ;
}

