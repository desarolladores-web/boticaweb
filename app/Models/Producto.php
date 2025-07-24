<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $principio_activo
 * @property float $pvp1
 * @property float $precio_costo_unitario
 * @property int $stock
 * @property int $stock_min
 * @property string|null $fecha_vencimiento
 * @property string|null $imagen (binario)
 * @property int|null $categoria_id
 * @property int|null $laboratorio_id
 * @property int|null $presentacion_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Categoria $categoria
 * @property Laboratorio $laboratorio
 * @property Presentacion $presentacion
 * @property Almacen[] $almacens
 * @property DetalleCompra[] $detalleCompras
 * @property DetalleVenta[] $detalleVentas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'principio_activo',
        'pvp1',
        'precio_costo_unitario',
        'stock',
        'stock_min',
        'fecha_vencimiento',
        'imagen', // imagen binaria
        'categoria_id',
        'laboratorio_id',
        'presentacion_id'
    ];

    /**
     * RELACIONES
     */

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }

    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class, 'presentacion_id');
    }

    public function almacens()
    {
        return $this->hasMany(Almacen::class, 'producto_id'); // corregido: el campo correcto de relación es producto_id
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'producto_id'); // corregido
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id'); // corregido
    }
}
