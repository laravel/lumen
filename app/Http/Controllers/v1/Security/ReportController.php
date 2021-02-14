<?php

namespace App\Http\Controllers\v1\Security;

use App\Http\Controllers\Controller;
use App\Models\v1\Report;
use App\Models\v1\ReportDetail;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Show list data
     * GET api/v1/security/report
     **/
	public function index()
	{
        try
        {
            $report = Report::with('message')->get()->toArray();
            return $this->respHandler->success('Berhasil mendapatkan data.', $report);
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Store report data request
     * POST api/v1/security/report/store
     **/
    public function storeReport(Request $request)
	{
        try
        {
            $get_time = Carbon::now('Asia/Bangkok');

            $new_report = new Report;
            $new_report->id_site_schedule = 1;
            $new_report->id_security_real = 1;
            $new_report->date = $get_time;
            $new_report->start = $get_time;
            $new_report->save();
            
            return $this->respHandler->success('Berhasil mengirimkan data.', $new_report->toArray());
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}

    /**
     * Store report_detail data request
     * POST api/v1/security/report/store/detail
     * @param Request long
     * @param Request lat
     * @param Request message
     * @param Request report_type
     * @param Request sos_to
     * @param Request message_type
     **/
    public function storeReportDetail(Request $request)
	{
        try
        {
            $new_report = new ReportDetail;
            $new_report->id_report = $id_report;
            $new_report->id_checkpoint = $id_checkpoint;
            $new_report->time = Carbon::now('Asia/Bangkok');
            $new_report->lat = $request->lat;
            $new_report->long = $request->long;
            $new_report->save();
            
            return $this->respHandler->success('Berhasil mengirimkan data.', $new_report->toArray());
        } 
        catch(\Exception $e)
        {
            return $this->respHandler->requestError($e->getMessage());
        }
	}
}
