@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">🛍️ Finalisation de la commande</h1>

    <!-- Récapitulatif du panier -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Récapitulatif de votre panier</h2>
        <table class="w-full mb-4">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Produit</th>
                    <th class="text-right py-2">Prix</th>
                    <th class="text-right py-2">Quantité</th>
                    <th class="text-right py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->name }}</td>
                    <td class="text-right">{{ number_format($item->price, 2) }} F CFA</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->quantity * $item->price, 2) }} F CFA</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td colspan="3" class="text-right py-2">Total :</td>
                    <td class="text-right">{{ number_format($total, 2) }} F CFA</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Formulaire d'informations client -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Vos informations</h2>
        <form method="POST" action="{{ route('checkout.process') }}" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2" for="nom">Nom *</label>
                    <input type="text" name="nom" id="nom" required 
                           class="w-full border rounded-md px-3 py-2 @error('nom') border-red-500 @enderror"
                           value="{{ old('nom') }}">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="prenom">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" required 
                           class="w-full border rounded-md px-3 py-2 @error('prenom') border-red-500 @enderror"
                           value="{{ old('prenom') }}">
                    @error('prenom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="email">Email *</label>
                    <input type="email" name="email" id="email" required 
                           class="w-full border rounded-md px-3 py-2 @error('email') border-red-500 @enderror"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="telephone">Téléphone *</label>
                    <input type="tel" name="telephone" id="telephone" required 
                           class="w-full border rounded-md px-3 py-2 @error('telephone') border-red-500 @enderror"
                           value="{{ old('telephone') }}">
                    @error('telephone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-2" for="adresse">Adresse de livraison *</label>
                    <input type="text" name="adresse" id="adresse" required 
                           class="w-full border rounded-md px-3 py-2 @error('adresse') border-red-500 @enderror"
                           value="{{ old('adresse') }}">
                    @error('adresse')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="ville">Ville *</label>
                    <input type="text" name="ville" id="ville" required 
                           class="w-full border rounded-md px-3 py-2 @error('ville') border-red-500 @enderror"
                           value="{{ old('ville') }}">
                    @error('ville')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="code_postal">Code postal *</label>
                    <input type="text" name="code_postal" id="code_postal" required 
                           class="w-full border rounded-md px-3 py-2 @error('code_postal') border-red-500 @enderror"
                           value="{{ old('code_postal') }}">
                    @error('code_postal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-green-500 text-white py-3 px-4 rounded-md hover:bg-green-600 transition">
                    ✅ Confirmer la commande
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
