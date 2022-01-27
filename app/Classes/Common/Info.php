<?php

namespace App\Classes\Common;

use App\Models\BoxOffice;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Throwable;
use SoapClient;

class Info
{
    public function getStoreInfo($params)
    {
        try {
            $param = $params['params'];

            $url = "http://10.0.0.28:80/endpoint";
            $headers = [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Accept' => 'application/json, text/plain, */*'
            ];
            $json = [
                'method' => $params['method'],
                'params' => [
                    'store_id' => $param['store_id'],
                ]
            ];

            //Отправляем запрос
            $client = new Client();
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'json' =>  $json
            ]);

            $res = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            return response($res)->header('Content-Type', 'application/json; charset=UTF-8');

        } catch (\Exception $e) {
            $res = $e->getMessage();
            $res = str_replace("\n", " ", $res);
            return response([
                'message' => 'err ' . $res . "/"
            ], $statusCode);
        }
    }
}

