<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tipo_documento_id',
        'DNI',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'direccion',
        'telefono',
        'email',
    ];

    public function usuario()
    {
        return $this->hasOne(User::class, 'cliente_id');
    }


    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }
}
