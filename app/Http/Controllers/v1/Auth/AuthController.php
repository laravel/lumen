<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Get token from login
     * POST api/v1/auth/login
     * @param username
     * @param password
     * @return Response 
     **/
	public function login(Request $request)
	{
        try 
        {
            $validator = Validator::make($request->post(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validator->validated())
            {
                $credentials = $request->only(['username', 'password']);

                if (! $token = Auth::attempt($credentials)) {			
                    return $this->respHandler->responseError('Unauthorized.');
                }
                
                return $this->respHandler->success('Succes get token bearer.', ['token' => $token]);
            }
            else
                return $this->respHandler->requestError($validator->errors());
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

     /**
     * Get user details. 
     * TEST CODE, REMOVE LATER
     * @param  Request  $request
     * @return Response
     */	 	
    public function me()
    {
        try 
        {
            $user = $this->authUser()->toArray();
            return $this->respHandler->success('Succes get user.', $user);
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
    }
}
