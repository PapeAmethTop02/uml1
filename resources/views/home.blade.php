@extends('layouts.app') {{-- Assure-toi que layouts.app existe --}}

@section('content')
<!-- Banner -->
<section class="relative h-screen bg-cover bg-center" style="background-image: url('https://wallpaperbat.com/img/228197-home-belin-super-market.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="text-center text-white" data-aos="fade-up">
            <h1 class="text-5xl font-bold mb-4">Bienvenue chez SuperMarket+</h1>
            <p class="text-xl mb-6">Vos courses en ligne, simples et rapides</p>
            
        </div>
    </div>
</section>

<!-- Catégories -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Nos catégories populaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in">
                <img src="/images/fruits.jpg" class="w-full h-56 object-cover" alt="Fruits">
                <div class="p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Fruits & Légumes</h3>
                    <p class="text-gray-600">Fraîcheur garantie tous les jours</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="100">
                <img src="/images/boissons.jpg" class="w-full h-56 object-cover" alt="Boissons">
                <div class="p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Boissons</h3>
                    <p class="text-gray-600">Jus, soda, eau, tout y est !</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="200">
                <img src="/images/produits-menagers.jpg" class="w-full h-56 object-cover" alt="Produits ménagers">
                <div class="p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Produits ménagers</h3>
                    <p class="text-gray-600">Un ménage impeccable à portée de clic</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Promo -->
<section class="bg-yellow-400 py-16" data-aos="fade-right">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold mb-4">Promo du mois 🌟</h2>
        <p class="text-lg mb-6">Profitez de -20% sur tous les produits bio jusqu’à la fin du mois !</p>
        <a href="" class="bg-black text-white px-6 py-3 rounded-full shadow-md hover:bg-gray-800 transition">
            Découvrir les promos
        </a>
    </div>
</section>

<!-- Témoignages -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Ce que disent nos clients</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-100 p-6 rounded-lg shadow" data-aos="fade-up">
                <p class="text-gray-700 italic">"J'adore la simplicité du site, j’ai pu faire toutes mes courses en 10 minutes."</p>
                <p class="mt-4 font-bold">– Fatou D.</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow" data-aos="fade-up" data-aos-delay="100">
                <p class="text-gray-700 italic">"Livraison rapide et produits bien emballés. Rien à redire !"</p>
                <p class="mt-4 font-bold">– Mamadou K.</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow" data-aos="fade-up" data-aos-delay="200">
                <p class="text-gray-700 italic">"Je recommande à 100%. Les promos sont top et le site super fluide."</p>
                <p class="mt-4 font-bold">– Aïssatou B.</p>
            </div>
        </div>
    </div>
</section>

<!-- Appel à l'action -->
<section class="bg-gray-900 text-white py-16 text-center" data-aos="zoom-in">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">Inscrivez-vous pour ne rien rater !</h2>
    <p class="mb-6">Recevez nos offres exclusives et nouveautés directement par mail</p>
    <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-6 py-3 rounded-full hover:bg-yellow-500 transition">
        Créer un compte
    </a>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endsection
