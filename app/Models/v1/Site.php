<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'sites';

    public function corporate()
    {
    	return $this->belongsTo('App\Models\v1\Corporate', 'id_corporate', 'id');
    }

    public function site_schedule()
    {
    	return $this->hasMany('App\Models\v1\SiteSchedule', 'id_site', 'id');
    }
}
