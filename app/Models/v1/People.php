<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People extends Model
{
    use HasFactory;
    protected $table = 'peoples';

    public function user()
    {
    	return $this->hasOne('App\Models\v1\User', 'id_people', 'id');
    }

    public function customer()
    {
    	return $this->hasOne('App\Models\v1\Customer', 'id_people', 'id');
    }

    public function security()
    {
    	return $this->hasOne('App\Models\v1\Security', 'id_people', 'id');
    }
}
