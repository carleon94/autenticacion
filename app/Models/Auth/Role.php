<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'slug', 'name', 'permissions'
    ];

    public function setPermissionsAttribute( $value ) {
        $this->attributes['permissions'] = json_encode( $value );
    }

    public function getPermissionsAttribute( $value ) {
        return json_decode( $this->attributes['permissions'] );
    }

    public function users() {
        return $this->belongsToMany( 'App\Models\Auth\User' , 'role_users' , 'role_id' , 'user_id' );
    }
}
