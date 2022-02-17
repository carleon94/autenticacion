<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Cartalyst\Sentinel\Users\EloquentUser;

class Auth extends EloquentUser
{
    protected $fillable = [
        'email',
        'username',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    protected $loginNames = [ 'email' ,  'username' ];
}
