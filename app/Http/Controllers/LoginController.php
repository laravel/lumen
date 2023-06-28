<?php

namespace App\Http\Controllers;

use App\Http\Util;
use App\Services\UserServices;
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
            return $this->failed('Email or Email code is not empty', -1);
        }


        $email_send_code = Redis::get(Util::$cache_email_code_key . $email);
        if (empty($email_send_code)) {
            return $this->failed('Please send your email code and login', -1);
        }

        if ($email_send_code != trim($email_code)) {
            return $this->failed('Your email code is wrong. Please Check your email code in your email inbox', -1);
        }

        $loginResult = UserServices::emailLogin($email);
        if (empty($loginResult)) {
            return $this->failed('Please send your email code and login', -1);
        }

        // jwt token @todo
        $token = UserServices::getJwt($loginResult);
        return $this->success(['token' => $token, 'email' => $email],'Congratulations, login is successful.');
    }

    public function emailCode(Request $request) {
        $email = $request->post('email', '');
        if (empty($email)) {
            return $this->failed('Email is not empty', -1);
        }

        if (!Util::checkEmail($email)) {
            return $this->failed('Email account is error', -1);
        }


        if (!empty(Redis::get(Util::$cache_email_code_key . $email))) {
            return $this->failed('Email code had send, please check you email', -1);
        }

        $rand = rand(111111, 999999);
        Redis::setex(Util::$cache_email_code_key . $email, 299, $rand);

        $subject = "Hello, Please check you email code to login";
        $mailContent = <<<MAILTEMPLATE
        Hi brother:
            Your email code is: {$rand}
            Please protect your Email code and do not disclose it to others
MAILTEMPLATE;

        $data = Mail::Raw($mailContent, function ($mail) use ($email, $subject) {
            $mail->subject($subject);
            $mail->to($email);
        });
        return $this->success($data, 'Email code had send, please check you email now');
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
