<?php

namespace App\Http\Controllers;

use App\Http\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function email(Request $request) {
        $email = $request->post('email', '');
        $email_code = $request->post('email_code', '');

        if (empty($email) || empty($email_code)) {
            return response()->json(['msg' => 'Email or Email code is not empty', 'code' => -1]);
        }

        $email_send_code = Redis::get(Util::$cache_email_code_key . $email);
        if (empty($email_send_code)) {
            return response()->json(['msg' => 'Please send your email code and login', 'code' => -1]);
        }

        if ($email_send_code != trim($email_code)) {
            return response()->json(['msg' => 'Your email code is wrong. Please Check your email code in your email box', 'code' => -1]);
        }




        exit;
    }

    public function emailCode(Request $request) {
        $email = $request->post('email', '');
        if (empty($email)) {
            return response()->json(['msg' => 'Email is not empty', 'code' => -1]);
        }

        if (!Util::checkEmail($email)) {
            return response()->json(['msg' => 'Email account is error', 'code' => -1]);
        }


        if (!empty(Redis::get(Util::$cache_email_code_key . $email))) {
            return response()->json(['msg' => 'Email code had send, please check you email', 'code' => -1]);
        }

        $rand = rand(111111, 999999);
        Redis::setex(Util::$cache_email_code_key . $email, 299, $rand);

        $subject = "Hello, Please check you email code to login";
        $mailContent = <<<MAILTEMPLATE
        Your email code is: {$rand}
        Please protect your Email code and do not disclose it to others
MAILTEMPLATE;

        Mail::Raw($mailContent, function ($mail) use ($email, $subject) {
            $mail->subject($subject);
            $mail->to($email);
        });

        return response()->json(['msg' => 'Email code had send, please check you email now.', 'code' => 200]);
    }


    public function googleBack() {
        echo 'hello google';
        exit;
    }

    public function facebookBack() {
        echo 'hello facebook';
        exit;
    }
}
