<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\People;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
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
     * @
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

            if($validator->validated())
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
     * POST api/v1/owner/people/update
     * @param Request id
     * @param Request name
     * @param Request address
     * @param Request phone_number
     * @param Request birthdate
     * @param Request age
     * @param Request sex
     * @return Response
     **/
    public function updatePeople(Request $request)
	{
        try
        {
            // dd($request->post() );
            $validator = Validator::make($request->post(), [
                'id' => 'required',
                'name' => 'required',
                'address' => 'required',
                'phone_number' => 'required',
                'birthdate' => 'required',
                'age' => 'required',
                'sex' => 'required'
            ]);

            if($validator->validated())
            {
                $new_people = People::find($request->id);
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
     * GET api/v1/owner/people/delete
     * @param id
     **/
    public function deleteUser($id)
	{
        try
        {
            $people = People::find($id)->delete();

            return $this->respHandler->success('Security has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

}
