<?php
/**
 * Descript:
 * Class ${NAME}
 * @author: shao.haizhou
 * @email: shaohaizhou@ksm
 * @Time: 2023/6/18   16:32
 */

namespace App\Services;

use App\Models\GBillImport;
use App\Models\GUser;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class UserServices
{
    /**
     * @param $email
     * @return void
     */
    public static function emailLogin($email)
    {

        if (empty($email)) return false;
        $emailCount = GUser::where('email', $email)->count();
        if (empty($emailCount)) {
            $emailObj = new GUser();
            $emailObj->email = trim($email);
            $emailObj->created_time = date("Y-m-d H:i:s");
            $emailObj->updated_time = date("Y-m-d H:i:s");
            $emailObj->account_type = 0;
            $emailObj->save();
            $user_id = $emailObj->id;
            $account_type = 0;
            $account_end_time = '';
            $account_start_time = '';
        } else {
            $userResult = GUser::where('email', $email)->first();
            $user_id = $userResult->id;
            $account_type = $userResult->account_type;
            $account_end_time = $userResult->end_time;
            $account_start_time = $userResult->start_time;
        }

        return [
            'user_id' => $user_id,
            'account_type' => $account_type,
            'account_start_time' => $account_start_time,
            'account_end_time' => $account_end_time,
        ];
    }

    /**
     * 生成jwt
     * @param $data
     * @return string
     */
    public static function getJwt($data)
    {
        $key = env('JWT_SECRET');
        $time = time();
        $ext_time = time() + 4 * 3600;
        $payload = array(
            "iat" => $time, // 签发时间
            "ext" => $ext_time, // 过期时间
            "data" => $data  // 携带数据
        );
//        $headers = [
//            'x-forwarded-for' => 'www.gatherdeals.org'
//        ];
        $jwt = JWT::encode($payload, $key, 'HS256', null);
        return $jwt;
    }

    /**
     * 验证jwt
     */
    public static function checkJwt($jwt)
    {
        try {
            $key = env('JWT_SECRET');
            return ['data' => JWT::decode($jwt, new Key($key, 'HS256')), 'code' => 200];
        } catch (ExpiredException $e) {
            return ['msg' => 'Token has expired, please login again', 'code' => -1];
        } catch (\Exception $e) {
            return ['msg' => 'Token is wrong, please login again', 'code' => -1];
        }
    }

    /**
     * 获取账单列表
     */
    public static function getBillList($user_id) {
        $data = [
            'count' => 0,
            'list' => [],
        ];
        $data['count'] = GBillImport::where('user_id', $user_id)->count();
        if (!empty($data['count'])) {
            $data['list'] = GBillImport::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        }
        return $data;
    }

    /**
     * 获取用户级别
     */
    public static function getUserLevel($user_id) {
        $user_info = GUser::find($user_id);
        return $user_info->account_type;
    }

    /**
     * 获取用户结束时间
     */
    public static function getUserExpireTime($user_id) {
        $user_info = GUser::find($user_id);
        return $user_info->end_time;
    }
}
