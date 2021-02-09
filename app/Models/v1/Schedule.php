<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    public function site_schedule()
    {
    	return $this->hasMany('App\Models\v1\SiteSchedule', 'id_schedule', 'id');
    }
}
