<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Nombre total de clients (exclure les administrateurs)
    $totalClients = User::where('role', '!=', 'admin')->count();

    // Nombre total de commandes
    $totalOrders = Order::count();

    // Montant total des ventes
    $totalSales = Order::where('status', 'livrée')->sum('total_price'); // Correction ici

    // Nombre total de produits en stock
    $totalStock = Product::sum('stock');

    // Statistiques des ventes des 7 derniers jours
    $salesByDay = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total_sales') // Correction ici
        )
        ->where('status', 'livrée')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->take(7)
        ->get();

    return view('admin.dashboard', compact('totalClients', 'totalOrders', 'totalSales', 'totalStock', 'salesByDay'));
}
}