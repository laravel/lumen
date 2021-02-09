<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    
    public function report()
    {
    	return $this->belongsTo('App\Models\v1\Report', 'id_report', 'id');
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\v1\User', 'id_user', 'id');
    }
}
