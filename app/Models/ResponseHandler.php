<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseHandler extends Model
{
    /**
     * Return response with code 200 Success
     **/
    public function success($message, $data = [])
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Return response with code 404 Not Found
     **/
    public function notFound($message)
    {
        return response()->json([
            'status' => 404,
            'message' => $message,
        ], 404);
    }

    /**
     * Return response with code 400 Bad Request
     **/
    public function requestError($message)
    {
        return response()->json([
            'status' => 400,
            'message' => $message,
        ], 400);
    }

    /**
     * Return response with code 500 Internal Server Error
     **/
    public function internalError($message)
    {
        return response()->json([
            'status' => 500,
            'message' => 'Internal server error.',
        ], 500);
    }
}
