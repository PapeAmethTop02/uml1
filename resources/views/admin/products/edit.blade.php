@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">✏️ Modifier le Produit</h1>

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Nom du produit" class="border p-2 w-full rounded mb-2">
        <textarea name="description" placeholder="Description du produit" class="border p-2 w-full rounded mb-2">{{ old('description', $product->description) }}</textarea>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="Prix (F CFA)" class="border p-2 w-full rounded mb-2">

        <!-- Champ pour le stock -->
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Quantité en stock" class="border p-2 w-full rounded mb-2" min="0" required>

        <select name="category_id" class="border p-2 w-full rounded mb-2">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <input type="file" name="image" class="border p-2 w-full rounded mb-2">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">✅ Modifier</button>
    </form>
</div>
@endsection
