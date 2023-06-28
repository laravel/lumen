<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function success($data = [], $msg = 'Success') {
        return response()->json(['msg' => $msg, 'code' => 200, 'data' => $data]);
    }

    public function failed($msg, $code = -1) {
        return response()->json(['msg' => $msg, 'code' => $code]);
    }
}
