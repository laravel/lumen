<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Common\Info;

class PosController extends Controller
{

    public function pos(Request $request)
    {
        $method =  $request->method;
        $params = $request->params ?? "";

        $info = new Info();
        switch ($method) {
            case 'GetStoreInfo':
                return $info->getStoreInfo($request);
                break;
            default:
                return response([
                    'message' => 'Method not found'
                ], 400);
        }
    }
}

