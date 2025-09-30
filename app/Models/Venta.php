<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 *
 * @property $id
 * @property $cliente_id
 * @property $fecha
 * @property $tipo_comprobante
 * @property $igv
 * @property $subtotal
 * @property $total
 * @property $metodo_pago_id
 * @property $estado_venta_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @property EstadoVenta $estadoVenta
 * @property MetodoPago $metodoPago
 * @property Comprobante[] $comprobantes
 * @property DetalleVenta[] $detalleVentas
 * @property Reclamo[] $reclamos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Venta extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cliente_id', 'fecha', 'tipo_comprobante', 'igv', 'subtotal', 'total', 'metodo_pago_id', 'estado_venta_id','imagen_comprobante'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
       protected $casts = [
        'fecha' => 'datetime',
    ];
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoVenta()
    {
        return $this->belongsTo(\App\Models\EstadoVenta::class, 'estado_venta_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metodoPago()
    {
        return $this->belongsTo(\App\Models\MetodoPago::class, 'metodo_pago_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comprobantes()
    {
        return $this->hasMany(\App\Models\Comprobante::class, 'venta_id', 'id');
    }

    public function detalleVentas()
    {
        return $this->hasMany(\App\Models\DetalleVenta::class, 'venta_id', 'id');
    }

    public function reclamos()
    {
        return $this->hasMany(\App\Models\Reclamo::class, 'venta_id', 'id');
    }
}
