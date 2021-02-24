<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Checkpoint;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CheckpointController extends Controller
{
    /**
     * Get checkpoint data
     * GET api/v1/owner/checkpoint/
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $checkpoint = $id ? Checkpoint::with('site')->find($id) : Checkpoint::with('site')->get();

            return $this->respHandler->success('Success get data.', $checkpoint);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Get checkpoint data by site
     * GET api/v1/owner/checkpoint/site
     * @param id
     * @return Response
     **/
	public function indexBySite($id)
	{
        try
        {
            $checkpoint = Checkpoint::where('id_site', $id)->get();

            return $this->respHandler->success('Success get data.', $checkpoint);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new checkpoint
     * POST api/v1/owner/checkpoint/store
     * @param Request id_site
     * @param Request name
     * @param Request detail
     * @param Request lat
     * @param Request long
     * @return Response
     **/
    public function storeCheckpoint(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_site' => 'required',
                'name' => 'required',
                'lat' => 'required',
                'long' => 'required',
            ]);

            if (! $validator->fails())
            {
                $checkpoint = new Checkpoint();
                $checkpoint->id_site = $request->id_site;
                $checkpoint->name = $request->name;
                $checkpoint->detail = $request->detail ? $request->detail : NULL;
                $checkpoint->lat = $request->lat;
                $checkpoint->long = $request->long;
                $checkpoint->save();

                return $this->respHandler->success('Checkpoint has been saved.', $checkpoint);
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
     * Update checkpoint
     * PUT api/v1/owner/checkpoint/update
     * @param id
     * @param Request id_site
     * @return Response
     **/
    public function updateCheckpoint(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_site' => 'required',
            ]);

            if (! $validator->fails())
            {
                $checkpoint = Checkpoint::find($id);
                $checkpoint->id_site = $request->id_site;
                $checkpoint->name = $request->name ? $request->name : $site->name;
                $checkpoint->detail = $request->detail ? $request->detail : $site->detail;
                $checkpoint->lat = $request->lat ? $request->lat : $checkpoint->lat;
                $checkpoint->long = $request->long ? $request->long : $checkpoint->long;
                $checkpoint->save();

                return $this->respHandler->success('Checkpoint has been updated.', $checkpoint);
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
     * Delete checkpoint
     * DELETE api/v1/owner/checkpoint/delete
     * @param id
     **/
    public function deleteCheckpoint($id)
	{
        try
        {
            $checkpoint = Checkpoint::find($id);

            if ($checkpoint)
                 $checkpoint->delete();
            else
                return $this->respHandler->requestError('Checkpoint not found.');

            return $this->respHandler->success('Checkpoint has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
