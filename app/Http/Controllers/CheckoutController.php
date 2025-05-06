<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = collect(Session::get('cart', []))->map(function ($item) {
            return (object) $item;
        });

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Votre panier est vide.');
        }

        $total = collect($cart)->sum(fn($item) => $item->price * $item->quantity);
        return view('checkout', compact('cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Création de la commande avec les informations client
        $order = Order::create([
            'total_price' => $totalPrice,
            'status' => 'en attente',
            'client_nom' => $request->nom,
            'client_prenom' => $request->prenom,
            'client_email' => $request->email,
            'client_telephone' => $request->telephone,
            'client_adresse' => $request->adresse,
            'client_ville' => $request->ville,
            'client_code_postal' => $request->code_postal,
        ]);

        // Création des items de la commande
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product && $product->stock >= $item['quantity']) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Mise à jour du stock
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Vider le panier
        Session::forget('cart');

        // Stocker l'ID de la commande dans la session pour le suivi
        Session::put('last_order_id', $order->id);

        return redirect()->route('checkout.success')->with('success', 'Votre commande a été enregistrée avec succès !');
    }

    public function success()
    {
        $orderId = Session::get('last_order_id');
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }

    public function trackOrder(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'order_id' => 'required|numeric'
        ]);

        $order = Order::where('client_email', $request->email)
                     ->where('id', $request->order_id)
                     ->first();

        if (!$order) {
            return back()->with('error', 'Commande non trouvée.');
        }

        return view('orders.track', compact('order'));
    }
}
