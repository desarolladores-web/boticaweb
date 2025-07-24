<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'tipo_documento_id',
    'rol_id',
    'cliente_id',
    'estado',
    'fecha_ingreso',
    'fecha_salida',
    'imagen', // 
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'estado' => 'boolean',
        'fecha_ingreso' => 'datetime',
        'fecha_salida' => 'datetime',
    ];

    public function cliente()
{
    return $this->belongsTo(Cliente::class);
}

public function tipoDocumento()
{
    return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
}

  public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function getIsAdminAttribute()
    {
        return $this->rol_id === 1;
    }
}
