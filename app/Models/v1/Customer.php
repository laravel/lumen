<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
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
