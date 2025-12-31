<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('nama')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|in:kg,pcs,papan',
            'harga_normal' => 'required|numeric|min:0',
            'harga_grosir' => 'nullable|numeric|min:0',
            'minimal_grosir' => 'nullable|integer|min:1',
            'stok_tersedia' => 'required|integer|min:0',
            'batas_kadaluarsa_hari' => 'required|integer|min:1|max:30',
            'gambar' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('gambar');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|in:kg,pcs,papan',
            'harga_normal' => 'required|numeric|min:0',
            'harga_grosir' => 'nullable|numeric|min:0',
            'minimal_grosir' => 'nullable|integer|min:1',
            'batas_kadaluarsa_hari' => 'required|integer|min:1|max:30',
            'gambar' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('gambar');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
        ]);

        if ($request->tipe === 'keluar' && $product->stok_tersedia < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Update stock
        if ($request->tipe === 'masuk') {
            $product->increment('stok_tersedia', $request->jumlah);
        } else {
            $product->decrement('stok_tersedia', $request->jumlah);
        }

        // Record stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'tipe' => $request->tipe,
            'jumlah' => $request->jumlah,
            'referensi_tipe' => 'penyesuaian',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Stok berhasil disesuaikan');
    }
}
