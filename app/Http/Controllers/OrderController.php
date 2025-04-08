<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;  // Assurez-vous que cette ligne est présente
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Affiche la liste des commandes de l'utilisateur connecté.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->with('orderItems.product')->get();
        return view('orders', compact('orders'));
    }

    /**
     * Stocke une nouvelle commande à partir du panier.
     */
    public function store()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }
    
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    
        // Création de la commande
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'en attente'
        ]);
    
        // Liste des erreurs de stock à afficher
        $stockErrors = [];
    
        // Vérification et mise à jour du stock
        foreach ($cart as $id => $item) {
            $product = Product::find($item['id']);
    
            if (!$product) {
                $stockErrors[] = "Le produit ID {$item['id']} n'existe pas.";
                continue;
            }
    
            // Vérifier si le stock est suffisant
            if ($product->stock < $item['quantity']) {
                $stockErrors[] = "Stock insuffisant pour le produit {$product->name}. Seulement {$product->stock} disponible.";
                continue;
            }
    
            // Ajouter l'article à la commande
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price']
            ]);
    
            // Réduire le stock du produit
            $product->decrement('stock', $item['quantity']);
        }
    
        // Vérifier s'il y a des erreurs de stock
        if (!empty($stockErrors)) {
            // Retourner à la page précédente avec tous les messages d'erreur
            return redirect()->back()->with('error', implode('<br>', $stockErrors));
        }
    
        // Vider le panier après la commande
        Session::forget('cart');
    
        return redirect()->route('orders', ['id' => $order->id])->with('success', 'Commande passée avec succès.');
    }
    


    /**
     * Affiche les détails d'une commande spécifique.
     */
    public function show($id)
    {
        $order = Order::with('orderItems.product')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('order_show', compact('order'));
    }

    /**
     * Annule une commande si elle est encore en attente.
     */
    public function destroy($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== 'en attente') {
            return redirect()->route('orders')->with('error', 'Vous ne pouvez annuler qu’une commande en attente.');
        }

        // Suppression des items liés
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('orders')->with('success', 'Commande annulée avec succès.');
    }
}
