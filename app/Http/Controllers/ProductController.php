<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();

        if (request()->has('category') && request()->category != '') {
            $query->where('category_id', request()->category);
        }

        if (request()->has('min_price') && request()->min_price != '') {
            $query->where('price', '>=', request()->min_price);
        }

        if (request()->has('max_price') && request()->max_price != '') {
            $query->where('price', '<=', request()->max_price);
        }

        if (request()->has('search') && request()->search != '') {
            $query->where('name', 'LIKE', '%' . request()->search . '%');
        }

        $products = $query->paginate(9);
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    public function showShop(Request $request)
    {
        return redirect()->route('home');
    }
}

