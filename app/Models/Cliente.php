<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Laravel usará 'id' como PK por defecto, pero lo dejamos explícito
    public $timestamps = true; // Si estás usando $table->timestamps() en la migración

    protected $fillable = [
        'nombre',
        'DNI',
        'apellido_paterno',
        'apellido_materno',
        'direccion',
        'telefono',
        'email',
        'imagen', // ✅ Añadir esto
    ];
    
    public function usuario()
    {
        return $this->hasOne(User::class, 'cliente_id');
    }
}
