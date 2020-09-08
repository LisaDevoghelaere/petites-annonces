<?php

namespace App;

class Crypt {

    public static $encryption_key = "a4g8r5hhmolj8r1ji";
    public static $cipher ="aes-128-cbc";

    public static function encrypt($string){

        $options = 0;
        $ivlen = openssl_cipher_iv_length((self::$cipher));

        $characters = "abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $iv = "";
        for($i=0; $i<$ivlen; $i++){
            $iv = $characters[random_int(0,51)];
        }

        $cipher_text = openssl_encrypt($string,self::$cipher,self::$encryption_key,$options,$iv);

        return $iv.$cipher_text;

    }


    // public static function decrypt($cipher_string){
    //     $options = 0;
    //     $ivlen = openssl_cipher_iv_length(self::$cipher);
    //     $iv = substr($cipher_string,0,$ivlen);
    //     $cipher_raw = substr($cipher_string,$ivlen);
    //     $text = openssl_decrypt($cipher_raw,self::$cipher,self::$encryption_key,$options,$iv);

    //     return $text;
    // }

    public static function hashCode($mail , $id){
        $concat = (self::encrypt($mail)).(self::encrypt($id));
        $code = hash('sha1',(urlencode($concat)));

        return $code;
    }


}