<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = collect(Session::get('cart', []))->map(function ($item) {
            return (object) $item;});


    if (empty($cart)) {
        return redirect()->route('cart')->with('error', 'Votre panier est vide.');
    }

    $total = collect($cart)->sum(fn($item) => $item->price * $item->quantity);


    return view('checkout', compact('cart', 'total'));
    }
}
