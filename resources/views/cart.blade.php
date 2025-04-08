@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">🛒 Mon Panier</h1>
    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2">Produit</th>
                <th class="py-2">Prix</th>
                <th class="py-2">Quantité</th>
                <th class="py-2">Total</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
        @if(count($cartItems) > 0)
    @foreach ($cartItems as $item)
        <tr>
            <td class="py-2">{{ $item->name }}</td>
            <td class="py-2">{{ $item->price }} F CFA</td>
            <td class="py-2">{{ $item->quantity }}</td>
            <td class="py-2">{{ $item->price * $item->quantity }} F CFA</td>
            <td class="py-2">
                <form method="POST" action="{{ route('cart.remove', ['id' => $item->id]) }}">
                    @csrf
                    <button class="bg-red-500 text-white px-2 py-1 rounded">🗑️ Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">Votre panier est vide.</td>
    </tr>
@endif
        </tbody>
    </table>
    <form action="{{ route('checkout') }}" method="GET" class="mt-4">
    @csrf
    <button type="submit" class="bg-green-500 text-white px-4 py-2">Passer la commande</button>
</form>
</div>
@endsection
