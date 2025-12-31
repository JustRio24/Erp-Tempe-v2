<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionBatch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index()
    {
        $batches = ProductionBatch::with('products')
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate(15);
        
        return view('admin.production.index', compact('batches'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.production.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        
        try {
            $batch = ProductionBatch::create([
                'tanggal_mulai' => $request->tanggal_mulai,
                'hari_ke' => 1,
                'status' => 'Hari ke-1',
                'jumlah_target' => array_sum(array_column($request->products, 'jumlah')),
                'catatan' => $request->catatan,
            ]);

            foreach ($request->products as $productData) {
                $batch->products()->attach($productData['id'], [
                    'jumlah' => $productData['jumlah']
                ]);
            }

            DB::commit();

            return redirect()->route('admin.production.index')->with('success', 'Batch produksi berhasil dibuat');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat batch: ' . $e->getMessage())->withInput();
        }
    }

    public function show(ProductionBatch $production)
    {
        $production->load('products', 'stockMovements');
        return view('admin.production.show', compact('production'));
    }

    public function advanceDay(ProductionBatch $production)
    {
        if ($production->hari_ke >= 4) {
            return back()->with('error', 'Batch sudah mencapai hari ke-4');
        }

        $production->advanceDay();

        return back()->with('success', 'Batch dimajukan ke ' . $production->status);
    }

    public function complete(ProductionBatch $production)
    {
        if ($production->status === 'Selesai') {
            return back()->with('error', 'Batch sudah selesai');
        }

        $production->complete();

        return redirect()->route('admin.production.index')->with('success', 'Batch selesai dan stok diperbarui');
    }

    public function recordFailure(Request $request, ProductionBatch $production)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $production->recordFailure($request->product_id, $request->jumlah);

        return back()->with('success', 'Kegagalan produksi dicatat');
    }
}
