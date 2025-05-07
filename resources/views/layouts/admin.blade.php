<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <!-- Barre de navigation -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('admin.dashboard') }}" class="font-bold">Tableau de bord</a>
            <div class="space-x-4">
                <a href="{{ route('admin.products.index') }}" class="hover:underline">Produits</a>
                <a href="{{ route('admin.stock.manage') }}" class="hover:underline">Stocks</a>
                <a href="{{ route('admin.orders.index') }}" class="hover:underline">Commandes</a>
                
                <!-- Bouton de déconnexion -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mx-auto">
        @yield('content')
    </div>
</body>
</html>
