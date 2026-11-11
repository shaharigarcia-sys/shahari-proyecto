<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('activo', true)->count(),
            'retornables' => Product::where('retornable', true)->count(),
            'total_users' => User::count(),
        ];

        $latestProducts = Product::latest()->take(5)->get();
        $settings = SiteSetting::allKeyed();

        return view('admin.dashboard', compact('stats', 'latestProducts', 'settings'));
    }
}
