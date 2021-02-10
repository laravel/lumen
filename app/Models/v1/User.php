<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public function people()
    {
    	return $this->belongsTo('App\Models\v1\People', 'id_people', 'id');
    }

    public function message()
    {
    	return $this->hasMany('App\Models\v1\Message', 'id_user', 'id');
    }
}
