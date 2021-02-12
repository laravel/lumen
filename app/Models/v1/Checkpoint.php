<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkpoint extends Model
{
    use HasFactory;
    protected $table = 'checkpoints';

    public function report_detail()
    {
    	return $this->hasMany('App\Models\v1\ReportDetail', 'id_checkpoint', 'id');
    }

    public function site()
    {
    	return $this->belongsTo('App\Models\v1\Site', 'id_site', 'id');
    }
}
