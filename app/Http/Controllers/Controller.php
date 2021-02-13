<?php

namespace App\Http\Controllers;

use App\Http\Controllers\v1\Helper\ResponseHandler;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $respHandler;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
    }

    public function authUser()
    {
        try 
        {
            $user = Auth::userOrFail();
            
            return $user;
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
    }
}
