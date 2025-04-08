@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">📦 Gestion des Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-green-500 text-white px-4 py-2 mt-4 inline-block">➕ Ajouter un produit</a>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2">Image</th>
                <th class="py-2">Nom</th>
                <th class="py-2">Prix</th>
                <th class="py-2">Catégorie</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b">
                <td class="py-2">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16">
                </td>
                <td class="py-2">{{ $product->name }}</td>
                <td class="py-2">{{ $product->price }} F CFA</td>
                <td class="py-2">{{ $product->category->name }}</td>
                <td class="py-2 flex space-x-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">✏️ Modifier</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 rounded">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
