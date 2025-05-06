<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // 📌 Voir les détails d'une commande
    public function show(Order $order)
    {
        $order->load('products');
        return view('admin.orders.show', compact('order'));
    }

    // 📌 Mettre à jour le statut d'une commande
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:en attente,paye,livree'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }
}

