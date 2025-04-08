@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">📝 Détails de la commande #{{ $order->id }}</h1>

    <h2 class="text-xl font-bold mt-2">Statut : 
        @if($order->status == 'en attente')
            <span class="text-orange-500">🕓 En attente</span>
        @elseif($order->status == 'payé')
            <span class="text-green-500">✅ Payé</span>
        @else
            <span class="text-blue-500">🚚 Livré</span>
        @endif
    </h2>

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
            @foreach($order->orderItems as $item)
            <tr class="border-b">
                <td class="py-2">{{ $item->product->name }}</td>
                <td class="py-2">{{ $item->price }} F CFA</td>
                <td class="py-2">{{ $item->quantity }}</td>
                <td class="py-2">{{ $item->price * $item->quantity }} F CFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
