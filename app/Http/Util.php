<?php
/**
 * Descript:
 * Class Util
 * @package App\Http
 * @author: shao.haizhou
 * @email: shaohaizhou@ksm
 * @Time: 2023/6/18   14:56
 */

namespace App\Http;

class Util
{
    public static $cache_email_code_key = "prod_email_code:";
    public static $cache_paypel_email_key = "prod_paypel_email_token:";
    /**
     * check email
     */
    public static function checkEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function randChar() {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $var_size = strlen($chars);

        $rand_str = '';
        for( $x = 0; $x < 8; $x++ ) {
            $rand_str .= $chars[ rand( 0, $var_size - 1 ) ];
        }
        $rand_str .= '-';
        for( $x = 0; $x < 8; $x++ ) {
            $rand_str .= $chars[ rand( 0, $var_size - 1 ) ];
        }
        $rand_str .= '-' . date("YmdHis") . rand(1111, 9999);
        return $rand_str;
    }
}
