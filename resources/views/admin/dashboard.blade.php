@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">📊 Tableau de Bord</h1>

    <!-- Cartes Statistiques -->
    <div class="grid grid-cols-4 gap-4 mt-6">
        <div class="bg-blue-500 text-white p-4 rounded shadow">
            <h2 class="text-xl">👥 Clients</h2>
            <p class="text-2xl font-bold">{{ $totalClients }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-4 rounded shadow">
            <h2 class="text-xl">📦 Commandes</h2>
            <p class="text-2xl font-bold">{{ $totalOrders }}</p>
        </div>
        <div class="bg-green-500 text-white p-4 rounded shadow">
            <h2 class="text-xl">💰 Ventes</h2>
            <p class="text-2xl font-bold">{{ number_format($totalSales, 2) }} F CFA</p>
        </div>
        <div class="bg-red-500 text-white p-4 rounded shadow">
            <h2 class="text-xl">🏪 Produits en stock</h2>
            <p class="text-2xl font-bold">{{ $totalStock }}</p>
        </div>
    </div>

    <!-- Graphique des ventes -->
    <div class="bg-white p-6 rounded shadow mt-6">
        <h2 class="text-2xl font-bold">📈 Ventes des 7 derniers jours</h2>
        <canvas id="salesChart"></canvas>
    </div>
</div>

<!-- Script pour Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesByDay->pluck('date')) !!},
            datasets: [{
                label: 'Ventes (F CFA)',
                data: {!! json_encode($salesByDay->pluck('total_sales')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        }
    });
</script>
@endsection
