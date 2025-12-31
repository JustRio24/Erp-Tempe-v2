<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang belanja kosong');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $harga = $product->getHargaByJumlah($quantity);
                $itemSubtotal = $harga * $quantity;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'harga' => $harga,
                    'subtotal' => $itemSubtotal,
                ];
                
                $subtotal += $itemSubtotal;
            }
        }

        $paymentMethods = config('erp.payment_methods');
        $shippingMethods = config('erp.shipping_methods');
        $banks = config('erp.payment_gateway.banks');

        return view('checkout.index', compact('cartItems', 'subtotal', 'paymentMethods', 'shippingMethods', 'banks'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'email_pembeli' => 'required|email|max:255',
            'telepon_pembeli' => 'required|string|max:20',
            'alamat_pembeli' => 'required|string',
            'metode_pembayaran' => 'required|in:transfer_bank,cod',
            'bank_tujuan' => 'required_if:metode_pembayaran,transfer_bank',
            'metode_pengiriman' => 'required|in:ambil_sendiri,kurir',
            'catatan' => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang belanja kosong');
        }

        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'nama_pembeli' => $request->nama_pembeli,
                'email_pembeli' => $request->email_pembeli,
                'telepon_pembeli' => $request->telepon_pembeli,
                'alamat_pembeli' => $request->alamat_pembeli,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bank_tujuan' => $request->bank_tujuan,
                'metode_pengiriman' => $request->metode_pengiriman,
                'ongkir' => $request->metode_pengiriman === 'kurir' ? 15000 : 0,
                'status' => 'pending',
                'catatan' => $request->catatan,
            ]);

            // Create order items
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                
                if (!$product || !$product->is_active) {
                    throw new \Exception('Produk tidak tersedia');
                }
                
                if ($product->stok_tersedia < $quantity) {
                    throw new \Exception('Stok produk ' . $product->nama . ' tidak mencukupi');
                }
                
                $harga = $product->getHargaByJumlah($quantity);
                $subtotal = $harga * $quantity;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'nama_produk' => $product->nama,
                    'jumlah' => $quantity,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                ]);
            }

            // Calculate order total
            $order->calculateTotal();
            
            // Update order status to 'diproses' and reduce stock
            $order->updateStatus('diproses');
            $order->reduceStock();

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
