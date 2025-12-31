<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        return view('home', compact('featuredProducts'));
    }

    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('nama')
            ->paginate(12);
        
        return view('catalog.index', compact('products'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
