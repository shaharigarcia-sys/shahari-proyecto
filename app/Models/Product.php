<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nombre',
        'marca',
        'categoria',
        'presentacion',
        'unidad',
        'precio',
        'imagen',
        'etiqueta',
        'retornable',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'retornable' => 'boolean',
        'activo' => 'boolean',
    ];

    public function getImagenUrlAttribute(): string
    {
        if (str_starts_with($this->imagen, 'uploads/')) {
            return asset('storage/' . $this->imagen);
        }
        return asset('assets/images/' . $this->imagen);
    }
}
