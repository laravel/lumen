<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\SecuritySchedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecurityScheduleController extends Controller
{
    /**
     * Get Security Schedule data
     * GET api/v1/owner/security-schedule
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try 
        {
            $security_schedule = $id ? SecuritySchedule::find($id) : SecuritySchedule::get();

            return $this->respHandler->success('Success get data.', $security_schedule);
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new Security Schedule
     * POST api/v1/owner/security-schedule/store
     * @param Request id_security_plan
     * @param Request id_site_schedule
     * @return Response
     **/
    public function storeSecuritySchedule(Request $request)
	{
        try 
        {
            $validator = Validator::make($request->post(), [
                'id_security_plan' => 'required',
                'id_site_schedule' => 'required'
            ]);
            
            if (! $validator->fails())
            {
                $new_security_schedule = new SecuritySchedule;
                $new_security_schedule->id_security_plan = $request->id_security_plan;
                $new_security_schedule->id_site_schedule = $request->id_site_schedule;
                $new_security_schedule->save();

                return $this->respHandler->success('Security Schedule has been saved.', $new_security_schedule);
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
     * Update Security Schedule
     * PUT api/v1/owner/security-schedule/update
     * @param id
     * @param Request id_security_plan
     * @param Request id_site_schedule
     * @return Response
     **/
    public function updateSecuritySchedule(Request $request, $id)
	{
        try 
        {
            $validator = Validator::make($request->post(), [
                'id_security_plan' => 'required',
                'id_site_schedule' => 'required'
            ]);
            
            if (! $validator->fails())
            {
                $new_security_schedule = SecuritySchedule::find($id);
                $new_security_schedule->id = $request->id;
                $new_security_schedule->id_security_plan = $request->id_security_plan;
                $new_security_schedule->id_site_schedule = $request->id_site_schedule;
                $new_security_schedule->save();

                return $this->respHandler->success('Security Schedule has been updated.', $new_security_schedule);
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
     * Delete Security Schedule
     * DELETE api/v1/owner/security-schedule/store
     * @param id
     **/
    public function deleteSecuritySchedule($id)
	{
        try 
        {
            $security = SecuritySchedule::find($id);

            if ($security)
                $security->delete();
            else
                return $this->respHandler->requestError('Security Schedule not found.');

            return $this->respHandler->success('Security Schedule has been deleted.');
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
