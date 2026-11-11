<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $product = new Product([
            'unidad' => 'Desde',
            'presentacion' => '1 Botella',
            'categoria' => 'Agua',
            'activo' => true,
            'retornable' => false,
        ]);

        return view('admin.products.form', [
            'product' => $product,
            'modo' => 'Crear',
            'action' => route('admin.products.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:160',
            'marca' => 'required|string|max:80',
            'categoria' => 'required|string|max:80',
            'presentacion' => 'required|string|max:60',
            'unidad' => 'required|string|max:40',
            'precio' => 'required|numeric|min:0.01',
            'etiqueta' => 'nullable|string|max:40',
            'retornable' => 'nullable|boolean',
            'activo' => 'nullable|boolean',
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
        ]);

        $validated['retornable'] = $request->boolean('retornable');
        $validated['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen_file')) {
            $path = $request->file('imagen_file')->store('uploads/products', 'public');
            $validated['imagen'] = $path;
        } else {
            $validated['imagen'] = 'producto-default.svg';
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'modo' => 'Editar',
            'action' => route('admin.products.update', $product),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:160',
            'marca' => 'required|string|max:80',
            'categoria' => 'required|string|max:80',
            'presentacion' => 'required|string|max:60',
            'unidad' => 'required|string|max:40',
            'precio' => 'required|numeric|min:0.01',
            'etiqueta' => 'nullable|string|max:40',
            'retornable' => 'nullable|boolean',
            'activo' => 'nullable|boolean',
            'imagen_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
        ]);

        $validated['retornable'] = $request->boolean('retornable');
        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen_file')) {
            if (str_starts_with($product->imagen, 'uploads/')) {
                Storage::disk('public')->delete($product->imagen);
            }
            $path = $request->file('imagen_file')->store('uploads/products', 'public');
            $validated['imagen'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if (str_starts_with($product->imagen, 'uploads/')) {
            Storage::disk('public')->delete($product->imagen);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
