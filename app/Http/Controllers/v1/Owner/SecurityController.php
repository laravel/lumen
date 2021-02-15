<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Security;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    /**
     * Get Security data
     * GET api/v1/owner/security/
     * @param id
     * @return Response
     * @
     **/
	public function index($id = NULL)
	{
        try
        {
            $security = $id ? Security::find($id) : Security::get();

            return $this->respHandler->success('Success get data.', $security);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new Security
     * POST api/v1/owner/security/store
     * @param Request id_people
     * @param Request id_supervisor
     * @param Request security_number
     * @return Response
     * @
     **/
    public function storeSecurity(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_people' => 'required'
            ]);

            if($validator->validated())
            {
                $new_security = new Security;
                $new_security->id_people = $request->id_people;
                $new_security->id_supervisor = $request->id_supervisor;
                $new_security->security_number = $request->security_number;
                $new_security->save();

                return $this->respHandler->success('Security has been saved.', $new_security);
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
     * Update Security
     * POST api/v1/owner/security/update
     * @param Request id
     * @param Request id_supervisor
     * @return Response
     **/
    public function updateSecurity(Request $request)
	{
        try
        {
            // dd($request->post() );
            $validator = Validator::make($request->post(), [
                'id' => 'required',
                'id_supervisor' => 'required',
                'security_number' => 'required'
            ]);

            if($validator->validated())
            {
                $new_security = Security::find($request->id);
                $new_security->id_supervisor = $request->id_supervisor;
                $new_security->security_number = $request->security_number;
                $new_security->save();

                return $this->respHandler->success('Security has been updated.', $new_security);
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
     * Delete Security
     * GET api/v1/owner/security/delete
     * @param id
     **/
    public function deleteSecurity($id)
	{
        try
        {
            $security = Security::find($id)->delete();

            return $this->respHandler->success('Security has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
