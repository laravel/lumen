<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';

    public function message()
    {
    	return $this->hasMany('App\Models\v1\Message', 'id_report', 'id');
    }
}
