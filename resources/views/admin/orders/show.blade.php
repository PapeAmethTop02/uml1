@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Détails de la commande #{{ $order->id }}</h1>

    <div class="bg-white p-4 rounded shadow-md">
        <p><strong>Client :</strong> {{ $order->user->name }}</p>
        <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Total :</strong> {{ $order->total_price }} F CFA</p>
        <p><strong>Statut :</strong> 
            <span class="px-2 py-1 rounded text-white 
                {{ $order->status == 'en attente' ? 'bg-yellow-500' : ($order->status == 'payé' ? 'bg-blue-500' : 'bg-green-500') }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>

        <h2 class="mt-4 font-semibold">Produits commandés :</h2>
        <ul class="list-disc ml-6">
            @foreach ($order->products as $product)
                <li>
                    {{ $product->name }} - Quantité : {{ $product->pivot->quantity }}
                </li>
            @endforeach
        </ul>

        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-6">
            @csrf
            <label for="status" class="block mb-2 font-medium">Modifier le statut :</label>
            <select name="status" id="status" class="border rounded px-3 py-2">
                <option value="en attente" {{ $order->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="payé" {{ $order->status == 'payé' ? 'selected' : '' }}>Payé</option>
                <option value="livrée" {{ $order->status == 'livrée' ? 'selected' : '' }}>Livrée</option>
            </select>
            <button type="submit" class="ml-3 bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
