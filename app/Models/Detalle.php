<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'precio',
        'cantidad',
        'importe',
        'especificacion',
        'producto_id',
        'pedido_id'
    ];

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }
    
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
