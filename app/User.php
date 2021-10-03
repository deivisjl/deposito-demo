<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    const USUARIO_ADMINISTRADOR = 'ADMINISTRADOR';

    const USUARIO_DIGITADOR = 'DIGITADOR';

    protected $date = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombres','apellidos','dpi','telefono','direccion', 'email', 'password','rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }

    public function esAdministrador(){

        return strtoupper($this->rol->nombre) == User::USUARIO_ADMINISTRADOR;

    }

    public function esDigitador(){

        return strtoupper($this->rol->nombre) == User::USUARIO_DIGITADOR;

    }
}
