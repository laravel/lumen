<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Get customer data
     * GET api/v1/owner/customer/
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $customer = $id ? Customer::with('people', 'corporate')->find($id) : Customer::with('people', 'corporate')->get();

            return $this->respHandler->success('Success get data.', $customer);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new customer
     * POST api/v1/owner/customer/store
     * @param Request id_people
     * @param Request id_corporate
     * @return Response
     **/
    public function storeCustomer(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_people' => 'required',
                'id_corporate' => 'required',
            ]);

            if (! $validator->fails())
            {
                $customer = new Customer();
                $customer->id_people = $request->id_people;
                $customer->id_corporate = $request->id_corporate;
                $customer->save();

                return $this->respHandler->success('Customer has been saved.', $customer);
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
     * Update customer
     * PUT api/v1/owner/customer/update
     * @param id
     * @param Request id_corporate
     * @return Response
     **/
    public function updateCustomer(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'id_corporate' => 'required',
            ]);

            if (! $validator->fails())
            {
                $customer = Customer::find($id);
                $customer->id_corporate = $request->id_corporate;
                $customer->save();

                return $this->respHandler->success('Customer has been updated.', $customer);
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
     * Delete customer
     * DELETE api/v1/owner/customer/delete
     * @param id
     **/
    public function deleteCustomer($id)
	{
        try
        {
            $customer = Customer::find($id);

            if ($customer)
                 $customer->delete();
            else
                return $this->respHandler->requestError('Customer not found.');

            return $this->respHandler->success('Customer has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
