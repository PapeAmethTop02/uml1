<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 📌 Afficher tous les produits
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 📌 Afficher le formulaire de création
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 📌 Enregistrer un nouveau produit
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $product = new Product($request->all());

        // Gérer l'upload d'image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès !');
    }

    // 📌 Afficher le formulaire d'édition
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 📌 Mettre à jour un produit
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $product->update($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour !');
    }

    // 📌 Supprimer un produit
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }
    public function updateStock(Request $request, $id)
{
    $request->validate([
        'stock' => 'required|integer|min:0',
    ]);

    $product = Product::findOrFail($id);
    $product->update(['stock' => $request->stock]);

    return redirect()->route('admin.stock.manage')->with('success', "Stock mis à jour !");

}
public function manageStock()
{
    $products = \App\Models\Product::all();
    return view('admin.stock.manage', compact('products'));
}



}

