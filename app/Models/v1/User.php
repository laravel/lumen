<?php

namespace App\Models\v1;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use HasFactory, Authenticatable, Authorizable;

    protected $table = 'users';

    protected $fillable = [
        'username',
    ];

    protected $hidden = [
        'password',
    ];

    public function people()
    {
    	return $this->belongsTo('App\Models\v1\People', 'id_people', 'id');
    }

    public function message()
    {
    	return $this->hasMany('App\Models\v1\Message', 'id_user', 'id');
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
