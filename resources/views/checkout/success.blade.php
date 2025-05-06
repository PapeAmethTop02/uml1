@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <div class="text-green-500 text-6xl mb-4">✅</div>
            <h1 class="text-3xl font-bold mb-2">Commande confirmée !</h1>
            <p class="text-gray-600">Merci pour votre commande. Voici un récapitulatif :</p>
        </div>

        <div class="border-t border-b py-4 my-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="font-semibold">Numéro de commande :</p>
                    <p class="text-gray-600">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="font-semibold">Total :</p>
                    <p class="text-gray-600">{{ number_format($order->total_price, 2) }} F CFA</p>
                </div>
                <div>
                    <p class="font-semibold">Email :</p>
                    <p class="text-gray-600">{{ $order->client_email }}</p>
                </div>
                <div>
                    <p class="font-semibold">Adresse de livraison :</p>
                    <p class="text-gray-600">
                        {{ $order->client_adresse }}<br>
                        {{ $order->client_code_postal }} {{ $order->client_ville }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informations de suivi -->
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <h2 class="font-semibold text-blue-800 mb-2">Comment suivre votre commande ?</h2>
            <p class="text-blue-600 mb-4">
                Pour suivre l'état de votre commande à tout moment, conservez ces informations :
            </p>
            <div class="bg-white p-4 rounded border border-blue-200">
                <div class="mb-2">
                    <span class="font-semibold">Numéro de commande :</span>
                    <span class="ml-2 text-blue-700">#{{ $order->id }}</span>
                </div>
                <div>
                    <span class="font-semibold">Email utilisé :</span>
                    <span class="ml-2 text-blue-700">{{ $order->client_email }}</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('orders.track-form') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    📦 Suivre ma commande
                </a>
            </div>
        </div>

        <div class="text-center">
            <p class="mb-4">Un email de confirmation a été envoyé à {{ $order->client_email }}</p>
            
            <a href="{{ route('home') }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded-md mt-4 hover:bg-green-600 transition">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection 