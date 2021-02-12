<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportDetail extends Model
{
    use HasFactory;
    protected $table = 'report_details';

    public function message()
    {
    	return $this->hasMany('App\Models\v1\Message', 'id_report_detail', 'id');
    }

    public function report()
    {
    	return $this->belongsTo('App\Models\v1\Report', 'id_report', 'id');
    }

    public function checkpoint()
    {
    	return $this->belongsTo('App\Models\v1\Checkpoint', 'id_checkpoint', 'id');
    }
}
