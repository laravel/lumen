<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
    /**
     * Get site data
     * GET api/v1/owner/site/
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $site = $id ? Site::with('checkpoint', 'corporate')->find($id) : Site::with('checkpoint', 'corporate')->get();

            return $this->respHandler->success('Success get data.', $site);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new site
     * POST api/v1/owner/site/store
     * @param Request id_corporate
     * @param Request name
     * @param Request address
     * @param Request detail
     * @param Request lat
     * @param Request long
     * @return Response
     **/
    public function storeSite(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_corporate' => 'required',
                'name' => 'required',
                'address' => 'required',
                'detail' => 'required',
                'lat' => 'required',
                'long' => 'required',
            ]);

            if (! $validator->fails())
            {
                $site = new Site();
                $site->id_corporate = $request->id_corporate;
                $site->name = $request->name;
                $site->address = $request->address;
                $site->detail = $request->detail ? $request->detail : NULL;
                $site->lat = $request->lat;
                $site->long = $request->long;
                $site->save();

                return $this->respHandler->success('Site has been saved.', $site);
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
     * Update site
     * PUT api/v1/owner/site/update
     * @param id
     * @param Request id_corporate
     * @return Response
     **/
    public function updateSite(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_corporate' => 'required',
                'lat' => 'required',
                'long' => 'required',
            ]);

            if (! $validator->fails())
            {
                $site = Site::find($id);
                $site->id_corporate = $request->id_corporate;
                $site->name = $request->name ? $request->name : $site->name;
                $site->address = $request->address ? $request->address : $site->address;
                $site->detail = $request->detail ? $request->detail : $site->detail;
                $site->lat = $request->lat;
                $site->long = $request->long;
                $site->save();

                return $this->respHandler->success('Site has been updated.', $site);
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
     * Delete site
     * DELETE api/v1/owner/site/delete
     * @param id
     **/
    public function deleteSite($id)
	{
        try
        {
            $site = Site::find($id);

            if ($site)
                 $site->delete();
            else
                return $this->respHandler->requestError('Site not found.');

            return $this->respHandler->success('Site has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
