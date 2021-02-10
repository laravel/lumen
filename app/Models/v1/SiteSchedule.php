<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class SiteSchedule extends Model
{
    protected $table = 'site_schedules';

    public function site()
    {
    	return $this->belongsTo('App\Models\v1\Site', 'id_site', 'id');
    }

    public function security_schedule()
    {
    	return $this->hasMany('App\Models\v1\SecuritySchedule', 'id_site_schedule', 'id');
    }

    public function schedule()
    {
    	return $this->belongsTo('App\Models\v1\Schedule', 'id_schedule', 'id');
    }
}
