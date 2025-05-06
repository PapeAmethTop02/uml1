@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Détails de la commande #{{ $order->id }}</h1>

    <div class="bg-white p-4 rounded shadow-md mb-6">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <h2 class="font-semibold mb-2">Informations Client</h2>
                <p><strong>Nom complet :</strong> {{ $order->client_prenom }} {{ $order->client_nom }}</p>
                <p><strong>Email :</strong> {{ $order->client_email }}</p>
                <p><strong>Téléphone :</strong> {{ $order->client_telephone }}</p>
            </div>
            <div>
                <h2 class="font-semibold mb-2">Adresse de livraison</h2>
                <p>{{ $order->client_adresse }}</p>
                <p>{{ $order->client_code_postal }} {{ $order->client_ville }}</p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="font-semibold mb-2">Détails de la commande</h2>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Total :</strong> {{ number_format($order->total_price, 2) }} F CFA</p>
            <p><strong>Statut :</strong> 
                <span class="px-2 py-1 rounded text-white 
                    {{ $order->status == 'en attente' ? 'bg-yellow-500' : ($order->status == 'paye' ? 'bg-blue-500' : 'bg-green-500') }}">
                    @if($order->status == 'en attente')
                        En attente
                    @elseif($order->status == 'paye')
                        Payé
                    @else
                        Livré
                    @endif
                </span>
            </p>
        </div>

        <h2 class="font-semibold mb-2">Produits commandés :</h2>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-2 px-4 text-left">Produit</th>
                    <th class="py-2 px-4 text-right">Prix unitaire</th>
                    <th class="py-2 px-4 text-right">Quantité</th>
                    <th class="py-2 px-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $product->name }}</td>
                        <td class="py-2 px-4 text-right">{{ number_format($product->pivot->price, 2) }} F CFA</td>
                        <td class="py-2 px-4 text-right">{{ $product->pivot->quantity }}</td>
                        <td class="py-2 px-4 text-right">{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} F CFA</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td colspan="3" class="py-2 px-4 text-right">Total :</td>
                    <td class="py-2 px-4 text-right">{{ number_format($order->total_price, 2) }} F CFA</td>
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-6">
            @csrf
            <div class="flex items-center gap-4">
                <label for="status" class="font-medium">Modifier le statut :</label>
                <select name="status" id="status" class="border rounded px-3 py-2">
                    <option value="en attente" {{ $order->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="paye" {{ $order->status == 'paye' ? 'selected' : '' }}>Payé</option>
                    <option value="livree" {{ $order->status == 'livree' ? 'selected' : '' }}>Livré</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Mettre à jour le statut
                </button>
            </div>
        </form>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">
        ← Retour à la liste des commandes
    </a>
</div>
@endsection
