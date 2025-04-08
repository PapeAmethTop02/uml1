@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">📦 Mes commandes</h1>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2">Numéro</th>
                <th class="py-2">Total</th>
                <th class="py-2">Statut</th>
                <th class="py-2">Détails</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">
                <td class="py-2">#{{ $order->id }}</td>
                <td class="py-2">{{ number_format($order->total_price, 2) }} F CFA</td>
                <td class="py-2">
                    @if($order->status == 'en attente')
                        <span class="text-orange-500">🕓 En attente</span>
                    @elseif($order->status == 'payé')
                        <span class="text-green-500">✅ Payé</span>
                    @else
                        <span class="text-blue-500">🚚 Livré</span>
                    @endif
                </td>
                <td class="py-2">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 underline">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Affichage des détails si une commande est sélectionnée -->
    @isset($orderDetails)
    <div class="mt-6 p-4 border rounded bg-gray-100">
        <h2 class="text-2xl font-bold">📝 Détails de la commande #{{ $orderDetails->id }}</h2>
        
        <h3 class="text-lg font-bold mt-2">Statut : 
            @if($orderDetails->status == 'en attente')
                <span class="text-orange-500">🕓 En attente</span>
            @elseif($orderDetails->status == 'payé')
                <span class="text-green-500">✅ Payé</span>
            @else
                <span class="text-blue-500">🚚 Livré</span>
            @endif
        </h3>

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
                @foreach($orderDetails->orderItems as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->product->name }}</td>
                    <td class="py-2">{{ number_format($item->price, 2) }} F CFA</td>
                    <td class="py-2">{{ $item->quantity }}</td>
                    <td class="py-2">{{ number_format($item->price * $item->quantity, 2) }} F CFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endisset
</div>
@endsection
