<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if ($product->stock <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Le produit {$product->name} n'est plus en stock."
                ]);
            }

            $cart = Session::get('cart', []);

            if (isset($cart[$id])) {
                if ($cart[$id]['quantity'] >= $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock insuffisant pour {$product->name}. Il reste {$product->stock} unité(s)."
                    ]);
                }
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'id' => $id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1
                ];
            }

            Session::put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier !',
                'cart_count' => array_sum(array_column($cart, 'quantity'))
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'ajout au panier : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout au panier.'
            ], 500);
        }
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Produit retiré du panier.');
        }
        
        return redirect()->back()->with('error', 'Produit non trouvé dans le panier.');
    }
}

