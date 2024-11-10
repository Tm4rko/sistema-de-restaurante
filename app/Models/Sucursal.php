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
}
