<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Show list data
     **/
	public function index()
	{
        try {
            // Start code here
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
