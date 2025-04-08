@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center">Bienvenue sur notre supermarché en ligne 🛒</h1>
    <form method="GET" action="{{ route('home') }}" class="flex flex-wrap gap-4 bg-gray-100 p-4 rounded-md">
    <!-- Recherche par nom -->
    <input type="text" name="search" placeholder="Rechercher un produit..." class="border p-2 rounded" value="{{ request('search') }}">

    <!-- Sélection de la catégorie -->
    <select name="category" class="border p-2 rounded">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <!-- Prix min -->
    <input type="number" name="min_price" placeholder="Prix min (€)" class="border p-2 rounded" value="{{ request('min_price') }}">

    <!-- Prix max -->
    <input type="number" name="max_price" placeholder="Prix max (€)" class="border p-2 rounded" value="{{ request('max_price') }}">

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">🔍 Filtrer</button>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    @forelse($products as $product)
        <div class="bg-white shadow-md p-4 rounded-lg">
         <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            <h2 class="text-lg font-semibold mt-2">{{ $product->name }}</h2>
            <p class="text-gray-500">{{ $product->description }}</p>
            <p class="text-xl font-bold text-blue-600 mt-2">{{ $product->price }} F CFA</p>
            <button class="add-to-cart bg-blue-500 text-white px-4 py-2 mt-4 rounded" data-id="{{ $product->id }}">
    Ajouter au panier
</button>

        </div>
    @empty
        <p class="text-center text-gray-500 col-span-3">Aucun produit trouvé.</p>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.add-to-cart').on('click', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            var productId = $(this).data('id'); // Récupère l'ID du produit cliqué

            $.ajax({
                url: '/panier/ajouter/' + productId, // Correction de l'URL
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' // Protection CSRF
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message); // Message de succès
                        $('#cart-total').text(response.total + " F CFA"); // Met à jour le total du panier
                    } else {
                        alert(response.message); // Affiche un message d'erreur
                    }
                },
                error: function() {
                    alert('Erreur lors de l\'ajout au panier.');
                }
            });
        });
    });
</script>


@endsection
