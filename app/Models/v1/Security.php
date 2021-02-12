<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Security extends Model
{
    use HasFactory;
    protected $table = 'securities';

    public function people()
    {
    	return $this->hasOne('App\Models\v1\People', 'id', 'id_people');
    }

    public function self_supervisor()
    {
    	return $this->belongsTo('App\Models\v1\Security', "id_supervisor", "id");
    }

    public function supervisor()
    {
    	return $this->hasMany('App\Models\v1\Security', 'id', 'id_supervisor');
    }

    public function report()
    {
    	return $this->hasMany('App\Models\v1\Report', 'id_security_real', 'id');
    }
}
