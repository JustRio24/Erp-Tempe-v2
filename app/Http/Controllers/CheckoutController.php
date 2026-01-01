<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Function index() biarkan sama seperti kode asli Anda...
    public function index()
    {
        // ... (kode load cart, dll) ...
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('catalog.index')->with('error', 'Keranjang kosong');

        // Logic hitung cart ... (sama seperti punya Anda)

        // Pass data ke view
        $cartItems = [];
        $subtotal = 0;
        foreach ($cart as $productId => $quantity) {
            // ... logic loop cart Anda ...
            $product = Product::find($productId);
            $harga = $product->getHargaByJumlah($quantity);
            $itemSubtotal = $harga * $quantity;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'harga' => $harga,
                'subtotal' => $itemSubtotal
            ];
            $subtotal += $itemSubtotal;
        }

        $paymentMethods = config('erp.payment_methods');
        $shippingMethods = config('erp.shipping_methods');
        $banks = config('erp.payment_gateway.banks');

        return view('checkout.index', compact('cartItems', 'subtotal', 'paymentMethods', 'shippingMethods', 'banks'));
    }

    public function process(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'email_pembeli' => 'required|email|max:255',
            'telepon_pembeli' => 'required|string|max:20',
            'alamat_pembeli' => 'required|string',
            'metode_pembayaran' => 'required|in:transfer_bank,cod',
            'metode_pengiriman' => 'required|in:ambil_sendiri,kurir',
            'catatan' => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            // Return JSON error jika cart kosong
            return response()->json(['status' => 'error', 'message' => 'Keranjang kosong', 'redirect' => route('catalog.index')], 400);
        }

        DB::beginTransaction();

        try {
            // Hitung Ongkir
            $ongkir = $request->metode_pengiriman === 'kurir' ? 15000 : 0;

            // Create Order
            $order = Order::create([
                'nama_pembeli' => $request->nama_pembeli,
                'email_pembeli' => $request->email_pembeli,
                'telepon_pembeli' => $request->telepon_pembeli,
                'alamat_pembeli' => $request->alamat_pembeli,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bank_tujuan' => null,
                'metode_pengiriman' => $request->metode_pengiriman,
                'ongkir' => $ongkir,
                'status' => 'pending',
                'catatan' => $request->catatan,
                'nomor_pesanan' => 'ORD-' . Str::upper(Str::random(10)), // Hasil: ORD-X7K9M2L1P0
            ]);

            // Create Items
            $subtotalOrder = 0;
            $hppOrder = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::with('consumptions.material')->find($productId);
                if ($product->stok_tersedia < $quantity) {
                    throw new \Exception("Stok {$product->nama} habis");
                }

                $harga = $product->getHargaByJumlah($quantity);
                $lineTotal = $harga * $quantity;
                $subtotalOrder += $lineTotal;
                $hppOrder += $product->calculateHpp() * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'nama_produk' => $product->nama,
                    'jumlah' => $quantity,
                    'harga_satuan' => $harga,
                    'subtotal' => $lineTotal,
                ]);
            }

            $order->subtotal = $subtotalOrder;
            $order->hpp_total = $hppOrder;
            $order->total = $subtotalOrder + $ongkir;
            $order->save();
            $order->reduceStock();

            // Variabel untuk response
            $snapToken = null;
            $redirectUrl = route('checkout.success', $order);

            // LOGIC MIDTRANS
            if ($request->metode_pembayaran === 'transfer_bank') {
                Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->nomor_pesanan,
                        'gross_amount' => (int) $order->total,
                    ],
                    'customer_details' => [
                        'first_name' => $order->nama_pembeli,
                        'email' => $order->email_pembeli,
                        'phone' => $order->telepon_pembeli,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $order->snap_token = $snapToken;
                $order->save();
            } else {
                // Jika COD, langsung update status diproses
                $order->updateStatus('diproses');
            }

            DB::commit();
            session()->forget('cart');

            // RETURN JSON UNTUK AJAX
            return response()->json([
                'status' => 'success',
                'order_id' => $order->nomor_pesanan,
                'snap_token' => $snapToken, // Token dikirim ke frontend
                'redirect_url' => $redirectUrl
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
