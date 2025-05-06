@extends('layouts.app') {{-- Assure-toi que layouts.app existe --}}

@section('content')
<!-- Banner -->
<section class="relative h-[400px] bg-cover bg-center" style="background-image: url('https://wallpaperbat.com/img/228197-home-belin-super-market.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="text-center text-white" data-aos="fade-up">
            <h1 class="text-5xl font-bold mb-4">Bienvenue chez SuperMarket+</h1>
            <p class="text-xl mb-6">Vos courses en ligne, simples et rapides</p>
        </div>
    </div>
</section>

<!-- Formulaire de suivi de commande -->
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg -mt-10 relative z-10 max-w-2xl">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold">📦 Suivre une commande</h2>
        <p class="text-gray-600">Entrez votre email et le numéro de commande pour suivre son statut</p>
    </div>
    <form action="{{ route('orders.track') }}" method="POST" class="flex flex-col md:flex-row gap-4">
        @csrf
        <input type="email" name="email" placeholder="Votre email" required 
               class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="number" name="order_id" placeholder="Numéro de commande" required 
               class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
            🔍 Suivre
        </button>
    </form>
    @if(session('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</div>

<!-- Filtres et Produits -->
<div class="container mx-auto p-6">
    <form method="GET" action="{{ route('home') }}" class="flex flex-wrap gap-4 bg-gray-100 p-4 rounded-md mb-6">
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
        <input type="number" name="min_price" placeholder="Prix min" class="border p-2 rounded" value="{{ request('min_price') }}">

        <!-- Prix max -->
        <input type="number" name="max_price" placeholder="Prix max" class="border p-2 rounded" value="{{ request('max_price') }}">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">🔍 Filtrer</button>
    </form>

    <!-- Liste des produits -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white shadow-md p-4 rounded-lg">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded">
                <h2 class="text-lg font-semibold mt-2">{{ $product->name }}</h2>
                <p class="text-gray-500">{{ $product->description }}</p>
                <p class="text-xl font-bold text-blue-600 mt-2">{{ number_format($product->price, 2) }} F CFA</p>
                <button class="add-to-cart bg-blue-500 text-white px-4 py-2 mt-4 rounded w-full hover:bg-blue-600 transition" data-id="{{ $product->id }}">
                    🛒 Ajouter au panier
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
</div>

<!-- Notifications -->
<div id="success-notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden">
    <span class="notification-message"></span>
</div>

<div id="error-notification" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg hidden">
    <span class="notification-message"></span>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    function showNotification(message, isError = false) {
        const notification = isError ? $('#error-notification') : $('#success-notification');
        notification.find('.notification-message').text(message);
        notification.removeClass('hidden').fadeIn();
        
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.addClass('hidden');
            });
        }, 3000);
    }

    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const productId = button.data('id');

        // Désactiver le bouton pendant l'ajout
        button.prop('disabled', true).html('Ajout en cours...');

        $.ajax({
            url: '/panier/ajouter/' + productId,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message);
                } else {
                    showNotification(response.message, true);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Une erreur est survenue lors de l\'ajout au panier.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showNotification(errorMessage, true);
                console.error('Erreur AJAX:', xhr);
            },
            complete: function() {
                // Réactiver le bouton
                button.prop('disabled', false).html('🛒 Ajouter au panier');
            }
        });
    });
});
</script>
@endpush
@endsection
