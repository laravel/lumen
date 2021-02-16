<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\People;
use App\Models\v1\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get User data
     * GET api/v1/owner/user/
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $user = $id ? User::with('people')->find($id) : User::with('people')->get();

            return $this->respHandler->success('Success get data.', $user);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new user
     * POST api/v1/owner/user/store
     * @param Request id_people
     * @param Request username
     * @param Request password
     * @param Request email
     * @return Response
     **/
    public function storeUser(Request $request)
	{
        try
        {
            if ($request->id_people)
            {
                $validator_check = [
                    'username' => 'required|unique:users',
                    'password' => 'required'
                ];
            }
            else
            {
                $validator_check = [
                    'name' => 'required',
                    'email' => 'required|email',
                    'username' => 'required|unique:users',
                    'password' => 'required'
                ];
            }
            $validator = Validator::make($request->post(), $validator_check);

            if (! $validator->fails())
            {
                $new_people = [];
                if (! $request->id_people)
                {
                    $new_people = new People();
                    $new_people->name = $request->name;
                    $new_people->address = $request->address;
                    $new_people->phone_number = $request->phone_number;
                    $new_people->birthdate = $request->birthdate;
                    $new_people->age = $request->age;
                    $new_people->sex = $request->sex;
                    $new_people->save();
                }

                $new_user = new User();
                $new_user->id_people = $request->id_people ? $request->id_people : $new_people->id;
                $new_user->username = $request->username;
                $new_user->password = $request->password;
                $new_user->email = $request->email;
                $new_user->save();

                $data = [
                    'people' => $new_people,
                    'user' => $new_user
                ];

                return $this->respHandler->success('User has been saved.', $data);
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
     * Update User
     * PUT api/v1/owner/user/update
     * @param id
     * @param Request username
     * @param Request password
     * @param Request email
     * @return Response
     **/
    public function updateUser(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'username' => 'required',
                'password' => 'required',
                'email' => 'required',
            ]);

            if (! $validator->fails())
            {
                $new_user = User::find($id);
                $new_user->username = $request->username;
                $new_user->password = Hash::make($request->Password);
                $new_user->email = $request->email;
                $new_user->save();

                return $this->respHandler->success('User has been updated.', $new_user);
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
     * Delete User
     * DELETE api/v1/owner/user/delete
     * @param id
     **/
    public function deleteUser($id)
	{
        try
        {
            $user = User::find($id);

            if ($user)
                 $user->delete();
            else
                return $this->respHandler->requestError('User not found.');

            return $this->reshandler->success ("User has been deleted.");
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
