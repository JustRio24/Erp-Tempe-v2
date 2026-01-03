<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $harga = $product->getHargaByJumlah($quantity);
                $subtotal = $harga * $quantity;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ];
                
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia');
        }

        $quantity = $request->quantity;
        
        // Check stock
        if ($product->stok_tersedia < $quantity) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Stok tidak mencukupi'], 400);
            }
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = session('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        session(['cart' => $cart]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_count' => count($cart)
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        
        if (isset($cart[$product->id])) {
            // Check stock
            if ($product->stok_tersedia < $request->quantity) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            
            $cart[$product->id] = $request->quantity;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Keranjang diperbarui');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Keranjang dikosongkan');
    }
}
