<?php

namespace App\Http\Controllers\v1\Security;

use App\Http\Controllers\Controller;
use App\Models\ResponseHandler;
use App\Models\v1\People;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    private $respHandler;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
    }

    /**
     * Show list data
     **/
	public function index()
	{
        try {
            // Start code here
            $result = People::with('user', 'security', 'customer')->get()->toArray();
            
            dd($result);

        } catch(\Exception $e){
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Store data request
     **/
    public function store(Request $request)
	{
        try {
            // Start code here
        } catch(\Exception $e){
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
