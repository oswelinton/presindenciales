<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use DB;
class User extends Authenticatable
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','permiso_admin','permiso_usuario'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $dates = ['deleted_at'];//para hacer un borrado logico de datos

    protected $hidden = [
        'password', 'remember_token',
    ];

        public function Documento()
    {
        return $this->hasMany('App\Documento');
    }
}
