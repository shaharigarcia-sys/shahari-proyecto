<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'cliente_nombre',
        'cliente_correo',
        'cliente_telefono',
        'direccion_entrega',
        'total',
        'total_productos',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
