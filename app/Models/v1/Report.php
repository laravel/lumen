<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    public function message()
    {
    	return $this->hasMany('App\Models\v1\Message', 'id_report', 'id');
    }
}
