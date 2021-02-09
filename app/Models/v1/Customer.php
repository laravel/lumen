<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public function people()
    {
    	return $this->hasOne('App\Models\v1\People', 'id', 'id_people');
    }

    public function corporate()
    {
    	return $this->hasOne('App\Models\v1\Corporate', 'id', 'id_corporate');
    }
}
