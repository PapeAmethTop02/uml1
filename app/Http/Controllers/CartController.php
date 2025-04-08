<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem; // Ajoute cette ligne


class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []); // Assurez-vous que $cart est toujours un tableau
        
        if (!is_array($cart)) {
            $cart = []; // Sécuriser contre les valeurs non attendues
        }
        $cartItems = array_map(function($item) {
            if (isset($item['id'], $item['name'], $item['price'], $item['quantity'])) {
                return new CartItem(
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity']
                );
            }
    
            // Si des données manquent, retourner null pour éviter des erreurs
            return null;
        }, $cart);
        $cartItems = array_filter($cartItems);

        $total = collect($cartItems)->sum(fn($item) => $item->price * $item->quantity);
        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $cart = Session::get('cart', []);

    // Vérifier si le stock est suffisant
    if (isset($cart[$id]) && $cart[$id]['quantity'] >= $product->stock) {
        return response()->json([
            'success' => false,
            'message' => "Le stock de {$product->name} est insuffisant. Il ne reste que {$product->stock} en stock."
        ]);
    }

    // Ajouter le produit au panier (si stock suffisant)
    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = ['id' => $id, 'name' => $product->name, 'price' => $product->price, 'quantity' => 1];
    }

    // Sauvegarder le panier dans la session
    Session::put('cart', $cart);

    // Calculer le total du panier
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    return response()->json([
        'success' => true,
        'message' => 'Produit ajouté au panier !',
        'total' => $total
    ]);
}


    public function remove($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Produit retiré du panier !');
    }
}

