@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">➕ Ajouter un Produit</h1>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        <input type="text" name="name" placeholder="Nom du produit" class="border p-2 w-full rounded mb-2">
        <textarea name="description" placeholder="Description du produit" class="border p-2 w-full rounded mb-2"></textarea>
        <input type="number" name="price" placeholder="Prix (F CFA)" class="border p-2 w-full rounded mb-2">
        
        <!-- Champ pour le stock -->
        <input type="number" name="stock" placeholder="Quantité en stock" class="border p-2 w-full rounded mb-2" min="0" value="0" required>
        
        <select name="category_id" class="border p-2 w-full rounded mb-2">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        <input type="file" name="image" class="border p-2 w-full rounded mb-2">
        
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">✅ Ajouter</button>
    </form>
</div>
@endsection
