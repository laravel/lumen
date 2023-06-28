<?php
/**
 * Descript:
 * Class Paypel
 * @package App\Helpers\PayGateway
 * @author: harris
 * @email: heizol.shao@gmail.com
 * @Time: 2023/6/28   14:53
 */

namespace App\Helpers\PayGateway;

use App\Http\Util;
use Illuminate\Support\Facades\Redis;

class Paypel
{
    private $uat_api_url = 'https://api-m.sandbox.paypal.com';
    private $api_url = 'https://api-m.paypal.com';

    /**
     * @desc 获取paypel 的token
     * @param $email
     * @return mixed
     */
    public function getAccessToken($email) {
        $paypel_token = Redis::get(Util::$cache_paypel_email_key . $email);
        if (!empty($paypel_token)) {
            return $paypel_token;
        }

        $url = '/v1/oauth2/token';
        $header = [
            'Content-Type: application/x-www-form-urlencoded'
        ];
        $body = [
            'grant_type' => 'client_credentials'
        ];

        $result = $this->curlPost($url, $body, $header, 1);
        if (isset($result['access_token']) && !empty($result['access_token'])) {
            Redis::set(Util::$cache_paypel_email_key . $email, $result['access_token'], $result['expires_in']);
        }
        return $result['access_token'] ?? '';
    }

    /**
     * @desc 创建订单
     * @return void
     */
    public function createOrder() {

    }



    /**
     * @desc 发送curl post 请求
     * @param $url
     * @param $body
     * @param $header
     * @param $is_pwd
     * @return mixed
     */
    public function curlPost($url, $body, $header = [], $is_pwd = 0) {

        $url = $this->uat_api_url . $url;
        $post_data = http_build_query($body);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        if ($is_pwd == 1) {
            $username = env('PAYPEL_UAT_CLIENT_ID');
            $password = env('PAYPEL_UAT_SECRET');
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        }
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        var_dump($status_code . ' >>> ');
        if ($status_code == 201) {
            //
        }
        curl_close ($ch);
        var_dump($result);
        return json_decode($result, true);
    }
}
