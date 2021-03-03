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
     **/
	public function index($id = NULL)
	{
        try
        {
            $security = $id ? Security::with('people')->find($id) : Security::with('people')->get();

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
     **/
    public function storeSecurity(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_people' => 'required',
                'security_number' => 'required'
            ]);

            if (! $validator->fails())
            {
                $new_security = new Security;
                $new_security->id_people = $request->id_people;
                $new_security->id_supervisor = $request->id_supervisor ? $request->id_supervisor : NULL;
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
     * PUT api/v1/owner/security/update
     * @param id
     * @param Request id_supervisor
     * @param Request security_number
     * @return Response
     **/
    public function updateSecurity(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'security_number' => 'required'
            ]);

            if (! $validator->fails())
            {
                $new_security = Security::find($id);
                $new_security->id_people = $request->id_people;
                $new_security->id_supervisor = $request->id_supervisor ? $request->id_supervisor : $new_security->id_supervisor;
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
     * DELETE api/v1/owner/security/delete
     * @param id
     **/
    public function deleteSecurity($id)
	{
        try
        {
            $security = Security::find($id);
            
            if ($security)
                $security->delete();
            else
                return $this->respHandler->requestError('Security not found.');

            return $this->respHandler->success('Security has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
