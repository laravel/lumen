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
    /**
     * check email
     */
    public static function checkEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
