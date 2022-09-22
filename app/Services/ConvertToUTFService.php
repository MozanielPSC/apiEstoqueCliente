<?php 

namespace App\Services;

    class ConvertToUTFService{
        public function __construct(){

        }

        public static function convertToUTF($dat)
            {
                if (is_string($dat)) {
                    return utf8_encode($dat);
                } elseif (is_array($dat)) {
                    $ret = [];
                    foreach ($dat as $i => $d) $ret[ $i ] = self::convertToUTF($d);
                    return $ret;
                } elseif (is_object($dat)) {
                    foreach ($dat as $i => $d) $dat->$i = self::convertToUTF($d);
                    return $dat;
                } else {
                    return $dat;
                }
            }
       
    }