<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
    protected $table = 'corporates';

    public function site()
    {
    	return $this->hasMany('App\Models\v1\Site', 'id_corporate', 'id');
    }
}
