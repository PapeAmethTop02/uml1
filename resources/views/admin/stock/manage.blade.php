@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">🛠️ Gérer le stock des produits</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white rounded shadow">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Produit</th>
                    <th class="p-3 text-left">Stock actuel</th>
                    <th class="p-3 text-left">Modifier</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b">
                        <td class="p-3">{{ $product->name }}</td>
                        <td class="p-3">{{ $product->stock }}</td>
                        <td class="p-3">
                            <form action="{{ route('admin.updateStock', ['id' => $product->id]) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="border rounded px-2 py-1 w-20">
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Mettre à jour</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
