<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::allKeyed();

        $query = Product::where('activo', true);

        // Búsqueda
        if ($request->filled('buscar')) {
            $buscar = trim($request->input('buscar'));
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('marca', 'like', "%{$buscar}%");
            });
        }

        // Filtro por marcas
        if ($request->filled('marcas') && is_array($request->input('marcas'))) {
            $query->whereIn('marca', $request->input('marcas'));
        }

        // Filtro solo retornables
        if ($request->boolean('retornables')) {
            $query->where('retornable', true);
        }

        // Ordenamiento
        match ($request->input('orden')) {
            'precio_asc' => $query->orderBy('precio', 'asc'),
            'precio_desc' => $query->orderBy('precio', 'desc'),
            'nombre' => $query->orderBy('nombre', 'asc'),
            default => $query->orderBy('id', 'asc'),
        };

        $products = $query->get();
        $marcasDisponibles = Product::distinct()->orderBy('marca')->pluck('marca');

        return view('public.index', compact('products', 'settings', 'marcasDisponibles'));
    }
}
