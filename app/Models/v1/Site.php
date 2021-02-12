<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;
    protected $table = 'sites';

    public function corporate()
    {
    	return $this->belongsTo('App\Models\v1\Corporate', 'id_corporate', 'id');
    }

    public function site_schedule()
    {
    	return $this->hasMany('App\Models\v1\SiteSchedule', 'id_site', 'id');
    }

    public function checkpoint()
    {
    	return $this->hasMany('App\Models\v1\Checkpoint', 'id_site', 'id');
    }
}
