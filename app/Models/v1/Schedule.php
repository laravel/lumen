<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedules';

    public function site_schedule()
    {
    	return $this->hasMany('App\Models\v1\SiteSchedule', 'id_schedule', 'id');
    }
}
