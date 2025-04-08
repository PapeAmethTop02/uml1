<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    

                    <!-- Si l'utilisateur est admin, afficher les liens de gestion -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
                            {{ __('Gérer les Produits') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.stock.manage')" :active="request()->routeIs('admin.stock.manage')">
                            {{ __('Gérer les Stocks') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                            {{ __('Gérer les Commandes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ __('Gérer les Utilisateurs') }}
                        </x-nav-link>
                    @endif

                    <!-- Si l'utilisateur est client, afficher les liens de commandes -->
                    @if(Auth::check() && Auth::user()->role === 'client')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                        <x-nav-link :href="route('cart')" :active="request()->routeIs('cart')">
                            {{ __('Mon Panier') }}
                        </x-nav-link>
                        <x-nav-link :href="route('checkout')" :active="request()->routeIs('checkout')">
                            {{ __('Paiement') }}
                        </x-nav-link>
                        <x-nav-link :href="route('orders')" :active="request()->routeIs('orders')">
                            {{ __('Mes Commandes') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Auth Check: Connexion, Inscription, ou Déconnexion -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(Auth::check())
                    <!-- Si connecté, afficher le nom + bouton Déconnexion -->
                    <div class="mr-4 text-gray-700 font-medium">{{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Déconnexion</button>
                    </form>
                @else
                    <!-- Si non connecté, afficher Connexion et Inscription -->
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-green-500 text-white rounded ml-2">Inscription</a>
                @endif
            </div>

            <!-- Hamburger (Menu Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
           

            @if(Auth::check() && Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
                    {{ __('Gérer les Produits') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.stock.manage')" :active="request()->routeIs('admin.stock.manage')">
                    {{ __('Gérer les Stocks') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                    {{ __('Gérer les Commandes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                    {{ __('Gérer les Utilisateurs') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::check() && Auth::user()->role === 'client')
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart')" :active="request()->routeIs('cart')">
                    {{ __('Mon Panier') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('checkout')" :active="request()->routeIs('checkout')">
                    {{ __('Paiement') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders')" :active="request()->routeIs('orders')">
                    {{ __('Mes Commandes') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Auth Links -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @if(Auth::check())
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                    <div class="font-medium text-base text-gray-800">Invité</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Déconnexion') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Connexion') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Inscription') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>
