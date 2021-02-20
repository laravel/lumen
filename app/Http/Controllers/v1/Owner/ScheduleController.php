<?php

namespace App\Http\Controllers\v1\Owner;

use App\Http\Controllers\Controller;
use App\Models\v1\Schedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ScheduleController extends Controller
{
    /**
     * Get schedule data
     * GET api/v1/owner/schedule
     * @param id
     * @return Response
     **/
	public function index($id = NULL)
	{
        try
        {
            $schedule = $id ? Schedule::find($id) : Schedule::all();

            return $this->respHandler->success('Success get data.', $schedule);
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Create new schedule
     * POST api/v1/owner/schedule/store
     * @param Request day
     * @param Request start
     * @param Request end
     * @return Response
     **/
    public function storeSchedule(Request $request)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                'start' => 'required',
                'end' => 'required',
            ]);

            if (! $validator->fails())
            {
                $schedule = new Schedule();
                $schedule->day = $request->day;
                $schedule->start = $request->start;
                $schedule->end = $request->end;
                $schedule->save();

                return $this->respHandler->success('Schedule has been saved.', $schedule);
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
     * Update schedule
     * PUT api/v1/owner/schedule/update
     * @param id
     * @param Request start
     * @param Request day
     * @param Request end
     * @return Response
     **/
    public function updateSchedule(Request $request, $id)
	{
        try
        {
            $validator = Validator::make($request->post(), [
                'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                'start' => 'required',
                'end' => 'required',
            ]);

            if (! $validator->fails())
            {
                $schedule = Schedule::find($id);
                $schedule->day = $request->day;
                $schedule->start = $request->start;
                $schedule->end = $request->end;
                $schedule->save();

                return $this->respHandler->success('Schedule has been updated.', $schedule);
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
     * Delete schedule
     * DELETE api/v1/owner/schedule/delete
     * @param id
     **/
    public function deleteSchedule($id)
	{
        try
        {
            $schedule = Schedule::find($id);

            if ($schedule)
                 $schedule->delete();
            else
                return $this->respHandler->requestError('Schedule not found.');

            return $this->respHandler->success('Schedule has been deleted.');
        }
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
