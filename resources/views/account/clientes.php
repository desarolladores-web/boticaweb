<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = 'clientes'; // Asegura el nombre correcto de la tabla
    protected $primaryKey = 'id'; // Por si acaso
    public $timestamps = true;

    protected $fillable = [
        'nombre', 'DNI', 'apellido_paterno', 'apellido_materno', 'direccion', 'telefono', 'email', 'imagen'
    ];
}
