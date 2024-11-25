<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'stock_sucursales')
            ->withPivot('stock', 'disponibilidad')
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($sucursal) {
            $productos = Producto::all();
            foreach ($productos as $producto) {
                $sucursal->productos()->attach($producto->id, [
                    'stock' => 0,
                    'disponibilidad' => true,
                ]);
            }
        });
    }
}
