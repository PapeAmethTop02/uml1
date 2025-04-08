@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">🛍️ Récapitulatif de la commande</h1>
    
    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2">Produit</th>
                <th class="py-2">Prix</th>
                <th class="py-2">Quantité</th>
                <th class="py-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
            <tr class="border-b">
                <td class="py-2">{{ $item->name }}</td>
                <td class="py-2">{{ $item->price }} F CFA</td>
                <td class="py-2">{{ $item->quantity }}</td>
                <td class="py-2">{{ $item->quantity * $item->price }} F CFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mt-4">Total : {{ $total }} F CFA</h2>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <button class="bg-green-500 text-white px-4 py-2 mt-4">✅ Valider la commande</button>
    </form>
</div>
@endsection
