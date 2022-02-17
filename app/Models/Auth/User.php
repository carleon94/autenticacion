<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'permissions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    protected $appends = [
        'name'
    ];

    public function roles() {
        return $this->belongsToMany( 'App\Models\Auth\Role', 'role_users' , 'user_id' , 'role_id' );
    }

    public function getNameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }

    public function getJWTIdentifier() {
		return $this->getKey();
	}

	public function getJWTCustomClaims() {
		return [];
	}
}
