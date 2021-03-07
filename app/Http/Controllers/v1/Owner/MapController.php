<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Map;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MapController extends Controller
{
    /**
     * Get map data
     * GET api/v1/owner/map/
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $map = $id ? Map::find($id) : Map::get();

            return $this->respHandler->success('Success get data.', $map);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new map
     * POST api/v1/owner/map/store
     * @param Request latitude
     * @param Request longitude
     * @return Response
     **/
    public function storeMap(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'latitude' => 'required',
                'longitude' => 'required',
                'zoom' => 'required',
            ]);

            if (! $validator->fails())
            {
                $map = new Map();
                $map->latitude = $request->latitude;
                $map->longitude = $request->longitude;
                $map->zoom = $request->zoom;
                $map->save();

                return $this->respHandler->success('Map has been saved.', $map);
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
     * Update map
     * PUT api/v1/owner/map/update
     * @param id
     * @param Request latitude
     * @param Request longitude
     * @return Response
     **/
    public function updateMap(Request $request, $id)
	{
        try
        {
            $map = Map::find($id);
            $map->latitude = $request->latitude ?? $map->latitude;
            $map->longitude = $request->longitude ?? $map->longitude;
            $map->zoom = $request->zoom ?? $map->zoom;
            $map->save();

            return $this->respHandler->success('Map has been updated.', $map);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Delete map
     * DELETE api/v1/owner/map/delete
     * @param id
     **/
    public function deleteMap($id)
	{
        try
        {
            $map = Map::find($id);

            if ($map)
                 $map->delete();
            else
                return $this->respHandler->requestError('Map not found.');

            return $this->respHandler->success('Map has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
