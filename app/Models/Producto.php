<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'imagen', 'precio_venta', 'fecha_ingreso', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($producto) {
            $sucursales = Sucursal::all();
            foreach ($sucursales as $sucursal) {
                // Asegúrate de que estás utilizando el método correcto para insertar registros 
                $sucursal->productos()->attach($producto->id, [
                    'stock' => 0,
                    'disponibilidad' => true,
                ]);
            }
        });
    }

    public function sucursales()
    {
        return $this->belongsToMany(Sucursal::class, 'stock_sucursales')
            ->withPivot('stock', 'disponibilidad')
            ->withTimestamps();
    }
}
