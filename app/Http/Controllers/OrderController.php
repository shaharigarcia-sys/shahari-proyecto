<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cartData = $request->input('cart');
        if (is_string($cartData)) {
            $cartData = json_decode($cartData, true);
        }

        if (empty($cartData) || !is_array($cartData)) {
            return redirect()->route('home')->with('error', 'Tu carrito está vacío.');
        }

        $user = Auth::user();

        return view('public.checkout', compact('cartData', 'user'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'cliente_nombre' => 'required|string|max:120',
            'cliente_correo' => 'required|email|max:150',
            'cliente_telefono' => 'required|string|max:20',
            'direccion_entrega' => 'required|string|max:255',
            'cart_items' => 'required|string',
        ]);

        $cartItems = json_decode($validated['cart_items'], true);
        if (empty($cartItems) || !is_array($cartItems)) {
            return redirect()->route('home')->with('error', 'Error al procesar el carrito.');
        }

        try {
            $order = DB::transaction(function () use ($validated, $cartItems) {
                $total = 0;
                $totalProductos = 0;

                foreach ($cartItems as $item) {
                    $precio = floatval($item['precio'] ?? 0);
                    $cantidad = intval($item['cantidad'] ?? 1);
                    $total += $precio * $cantidad;
                    $totalProductos += $cantidad;
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'cliente_nombre' => $validated['cliente_nombre'],
                    'cliente_correo' => $validated['cliente_correo'],
                    'cliente_telefono' => $validated['cliente_telefono'],
                    'direccion_entrega' => $validated['direccion_entrega'],
                    'total' => $total,
                    'total_productos' => $totalProductos,
                    'estado' => 'completado',
                ]);

                foreach ($cartItems as $item) {
                    $precio = floatval($item['precio'] ?? 0);
                    $cantidad = intval($item['cantidad'] ?? 1);

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'] ?? null,
                        'nombre_producto' => $item['nombre'] ?? 'Producto',
                        'precio' => $precio,
                        'cantidad' => $cantidad,
                        'subtotal' => $precio * $cantidad,
                    ]);
                }

                return $order;
            });

            return redirect()->route('orders.ticket', $order->id);

        } catch (\Exception $e) {
            return back()->with('error', 'No fue posible registrar tu pedido: ' . $e->getMessage())->withInput();
        }
    }

    public function ticket(Order $order)
    {
        $order->load('details');
        return view('public.ticket', compact('order'));
    }
}
