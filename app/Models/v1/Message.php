<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    
    public function report_detail()
    {
    	return $this->belongsTo('App\Models\v1\ReportDetail', 'id_report_detail', 'id');
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\v1\User', 'id_user', 'id');
    }
}
