<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Corporate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CorporateController extends Controller
{
    /**
     * Get corporate data
     * GET api/v1/owner/corporate
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $corporate = $id ? Corporate::with('site', 'customer')->find($id) : Corporate::with('site', 'customer')->get();

            return $this->respHandler->success('Success get data.', $corporate);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new corporate
     * POST api/v1/owner/corporate/store
     * @param Request name
     * @param Request address
     * @return Response
     **/
    public function storeCorporate(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'name' => 'required',
                'address' => 'required',
            ]);

            if (! $validator->fails())
            {
                $corporate = new Corporate();
                $corporate->name = $request->name;
                $corporate->address = $request->address;
                // Change owner from database
                // $corporate->is_owner = $request->is_owner ? 1 : 0;
                $corporate->save();

                return $this->respHandler->success('Corporate has been saved.', $corporate);
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
     * Update corporate
     * PUT api/v1/owner/corporate/update
     * @param id
     * @param Request name
     * @param Request address
     * @return Response
     **/
    public function updateCorporate(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'name' => 'required',
                'address' => 'required',
            ]);

            if (! $validator->fails())
            {
                $corporate = Corporate::find($id);
                $corporate->name = $request->name;
                $corporate->address = $request->address;
                $corporate->save();

                return $this->respHandler->success('Corporate has been updated.', $corporate);
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
     * Delete corporate
     * DELETE api/v1/owner/corporate/delete
     * @param id
     **/
    public function deleteCorporate($id)
	{
        try
        {
            $corporate = Corporate::find($id);

            if ($corporate)
                 $corporate->delete();
            else
                return $this->respHandler->requestError('Corporate not found.');

            return $this->respHandler->success('Corporate has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
