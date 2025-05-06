@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold mb-6">📦 Suivi de commande #{{ $order->id }}</h1>

        <!-- Informations de la commande -->
        <div class="mb-8">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h2 class="font-semibold text-gray-600">Date de commande</h2>
                    <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-600">Total</h2>
                    <p>{{ number_format($order->total_price, 2) }} F CFA</p>
                </div>
            </div>
        </div>

        <!-- Statut de la commande -->
        <div class="mb-8">
            <h2 class="font-semibold text-gray-600 mb-4">Statut actuel</h2>
            <div class="flex items-center">
                @if($order->status == 'en attente')
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full">🕒 En attente</span>
                @elseif($order->status == 'paye')
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full">💳 Payé</span>
                @elseif($order->status == 'livree')
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full">✅ Livré</span>
                @endif
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="mb-8">
            <div class="relative">
                <div class="flex justify-between mb-2">
                    <div class="text-center">
                        <div class="w-8 h-8 mx-auto rounded-full {{ $order->status != '' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">✓</div>
                        <div class="text-sm mt-1">Commande reçue</div>
                    </div>
                    <div class="text-center">
                        <div class="w-8 h-8 mx-auto rounded-full {{ in_array($order->status, ['paye', 'livree']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">✓</div>
                        <div class="text-sm mt-1">Paiement confirmé</div>
                    </div>
                    <div class="text-center">
                        <div class="w-8 h-8 mx-auto rounded-full {{ $order->status == 'livree' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">✓</div>
                        <div class="text-sm mt-1">Livré</div>
                    </div>
                </div>
                <div class="h-2 bg-gray-200 rounded">
                    <div class="h-full bg-green-500 rounded transition-all duration-500
                        {{ $order->status == 'en attente' ? 'w-1/3' : ($order->status == 'paye' ? 'w-2/3' : 'w-full') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails des produits -->
        <div class="mb-8">
            <h2 class="font-semibold text-gray-600 mb-4">Produits commandés</h2>
            <div class="border rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Produit</th>
                            <th class="px-4 py-2 text-right">Quantité</th>
                            <th class="px-4 py-2 text-right">Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item->product->name }}</td>
                                <td class="px-4 py-2 text-right">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($item->price * $item->quantity, 2) }} F CFA</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Adresse de livraison -->
        <div>
            <h2 class="font-semibold text-gray-600 mb-2">Adresse de livraison</h2>
            <p>{{ $order->client_prenom }} {{ $order->client_nom }}</p>
            <p>{{ $order->client_adresse }}</p>
            <p>{{ $order->client_code_postal }} {{ $order->client_ville }}</p>
        </div>
    </div>
</div>
@endsection 