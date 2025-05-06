@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">🛒 Mon Panier</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Produit</th>
                        <th class="text-right py-2">Prix unitaire</th>
                        <th class="text-right py-2">Quantité</th>
                        <th class="text-right py-2">Total</th>
                        <th class="text-right py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        <tr class="border-b">
                            <td class="py-4">{{ $item['name'] }}</td>
                            <td class="text-right py-4">{{ number_format($item['price'], 2) }} F CFA</td>
                            <td class="text-right py-4">{{ $item['quantity'] }}</td>
                            <td class="text-right py-4">{{ number_format($item['price'] * $item['quantity'], 2) }} F CFA</td>
                            <td class="text-right py-4">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-4 font-bold">Total :</td>
                        <td class="text-right py-4 font-bold">{{ number_format($total, 2) }} F CFA</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('home') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
                    ← Continuer mes achats
                </a>
                <a href="{{ route('checkout') }}" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition">
                    Passer la commande →
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500 mb-4">Votre panier est vide</p>
            <a href="{{ route('home') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                Découvrir nos produits
            </a>
        </div>
    @endif
</div>
@endsection
