<?php

namespace App;

class Crypt {

    public static function encrypt_decrypt($action, $string) {
        $output = false;
    
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'a4g8r5hhmolj8r1ji';
        $characters = "abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $secret_iv = $characters[random_int(0,51)];
        $iv = "";
        $ivlen = openssl_cipher_iv_length(($encrypt_method));
        for($i=0; $i<$ivlen; $i++){
                 $iv = $iv. $characters[random_int(0,51)];
            }
    
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
    
        return $output;
    }






    // public static $encryption_key = "a4g8r5hhmolj8r1ji";
    // public static $cipher ="aes-128-cbc";

    // public static function encrypt($string){

    //     $options = 0;
    //     $ivlen = openssl_cipher_iv_length((self::$cipher));

    //     $characters = "abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    //     $iv = "";
    //     for($i=0; $i<$ivlen; $i++){
    //         $iv = $characters[random_int(0,51)];
    //     }

    //     $cipher_text = openssl_encrypt($string,self::$cipher,self::$encryption_key,$options,$iv);

    //     return $iv.$cipher_text;

    // }


    // public static function decrypt($cipher_string){
    //     $options = 0;
    //     $ivlen = openssl_cipher_iv_length(self::$cipher);
    //     $iv = substr($cipher_string,0,$ivlen);
    //     $cipher_raw = substr($cipher_string,$ivlen);
    //     $text = openssl_decrypt($cipher_raw,self::$cipher,self::$encryption_key,$options,$iv);

    //     return $text;
    // }

    // public static function hashCode($mail , $id){
    //     $concat = (self::encrypt($mail)).(self::encrypt($id));
    //     $code = hash('sha1',(urlencode($concat)));

    //     return $code;
    // }


}