<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\SiteSchedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SiteScheduleController extends Controller
{
    /**
     * Get site schedule data
     * GET api/v1/owner/site/schedule
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $site_schedule = $id ? SiteSchedule::with('site', 'schedule')->find($id) : SiteSchedule::with('site', 'schedule')->get();

            return $this->respHandler->success('Success get data.', $site_schedule);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new site schedule
     * POST api/v1/owner/site/schedule/store
     * @param Request id_site
     * @param Request id_schedule
     * @return Response
     **/
    public function storeSiteSchedule(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_site' => 'required',
                'id_schedule' => 'required',
            ]);

            if (! $validator->fails())
            {
                $site_schedule = new SiteSchedule();
                $site_schedule->id_site = $request->id_site;
                $site_schedule->id_schedule = $request->id_schedule;
                $site_schedule->save();

                return $this->respHandler->success('Site schedule has been saved.', $site_schedule);
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
     * Update site schedule
     * PUT api/v1/owner/site/schedule/update
     * @param id
     * @param Request id_schedule
     * @return Response
     **/
    public function updateSiteSchedule(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_schedule' => 'required',
            ]);

            if (! $validator->fails())
            {
                $site_schedule = SiteSchedule::find($id);
                $site_schedule->id_schedule = $request->id_schedule;
                $site_schedule->save();

                return $this->respHandler->success('Site schedule has been updated.', $site_schedule);
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
     * Delete site schedule
     * DELETE api/v1/owner/site/schedule/delete
     * @param id
     **/
    public function deleteSiteSchedule($id)
	{
        try
        {
            $site_schedule = SiteSchedule::find($id);

            if ($site_schedule)
                 $site_schedule->delete();
            else
                return $this->respHandler->requestError('Site schedule not found.');

            return $this->respHandler->success('Site schedule has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
