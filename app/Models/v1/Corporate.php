<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corporate extends Model
{
    use HasFactory;
    protected $table = 'corporates';

    public function site()
    {
    	return $this->hasMany('App\Models\v1\Site', 'id_corporate', 'id');
    }
}
