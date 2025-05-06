@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Liste des Commandes</h1>

    <table class="w-full border-collapse bg-white shadow-md rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 text-left">Client</th>
                <th class="py-2 px-4 text-left">Email</th>
                <th class="py-2 px-4 text-left">Téléphone</th>
                <th class="py-2 px-4 text-left">Produits</th>
                <th class="py-2 px-4 text-left">Total</th>
                <th class="py-2 px-4 text-left">Statut</th>
                <th class="py-2 px-4 text-left">Date</th>
                <th class="py-2 px-4 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $order->client_prenom }} {{ $order->client_nom }}</td>
                    <td class="py-2 px-4">{{ $order->client_email }}</td>
                    <td class="py-2 px-4">{{ $order->client_telephone }}</td>
                    <td class="py-2 px-4">{{ $order->products->sum('pivot.quantity') }} produit(s)</td>
                    <td class="py-2 px-4">{{ number_format($order->total_price, 2) }} F CFA</td>
                    <td class="py-2 px-4">
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
                    </td>
                    <td class="py-2 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
