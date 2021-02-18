<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\People;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    /**
     * Get people data
     * GET api/v1/owner/people/
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $people = $id ? People::find($id) : People::all();

            return $this->respHandler->success('Success get data.', $people);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new people
     * POST api/v1/owner/people/store
     * @param Request name
     * @param Request address
     * @param Request phone_number
     * @param Request birthdate
     * @param Request age
     * @param Request sex
     * @return Response
     **/
    public function storePeople(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'name' => 'required',
                'address' => 'required',
                'phone_number' => 'required',
                'birthdate' => 'required',
                'age' => 'required',
                'sex' => 'required'
            ]);

            if (! $validator->fails())
            {
                $new_people = new People();
                $new_people->name = $request->name;
                $new_people->address = $request->address;
                $new_people->phone_number = $request->phone_number;
                $new_people->age = $request->age;
                $new_people->sex = $request->sex;
                $new_people->save();

                return $this->respHandler->success('People has been saved.', $new_people);
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
     * Update people
     * PUT api/v1/owner/people/update
     * @param id
     * @param Request name
     * @param Request address
     * @param Request phone_number
     * @param Request birthdate
     * @param Request age
     * @param Request sex
     * @return Response
     **/
    public function updatePeople(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'name' => 'required',
                'address' => 'required',
                'phone_number' => 'required',
                'birthdate' => 'required',
                'age' => 'required',
                'sex' => 'required'
            ]);

            if (! $validator->fails())
            {
                $new_people = People::find($id);
                $new_people->name = $request->name;
                $new_people->address = $request->address;
                $new_people->phone_number = $request->phone_number;
                $new_people->age = $request->age;
                $new_people->sex = $request->sex;
                $new_people->save();

                return $this->respHandler->success('People has been updated.', $new_people);
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
     * Delete People
     * DELETE api/v1/owner/people/delete
     * @param id
     **/
    public function deleteUser($id)
	{
        try
        {
            $people = People::find($id);

            if ($people)
                 $people->delete();
            else
                return $this->respHandler->requestError('People not found.');

            return $this->respHandler->success('People has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
