<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok_minimal' => 'required|numeric|min:0',
        ]);

        Material::create($request->all());

        return redirect()->route('admin.materials.index')->with('success', 'Bahan baku berhasil ditambahkan');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok_minimal' => 'required|numeric|min:0',
        ]);

        $material->update($request->all());

        return redirect()->route('admin.materials.index')->with('success', 'Bahan baku berhasil diperbarui');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Bahan baku berhasil dihapus');
    }

    public function restock(Request $request, Material $material)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0.01',
            'harga_total' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Add Stock & Movement
            $material->addStock(
                $request->jumlah, 
                'pembelian', 
                null, 
                $request->keterangan ?? "Pembelian {$request->jumlah} {$material->satuan} {$material->nama}"
            );

            // 2. Create Financial Record (Expense)
            FinancialRecord::create([
                'tanggal' => now(),
                'tipe' => 'pengeluaran',
                'kategori' => 'Bahan Baku',
                'jumlah' => $request->harga_total,
                'deskripsi' => "Beli {$material->nama}: {$request->jumlah} {$material->satuan}. " . ($request->keterangan ?? ''),
                'referensi_tipe' => 'pembelian_bahan',
                'referensi_id' => $material->id,
            ]);

            DB::commit();
            return back()->with('success', 'Stok berhasil ditambah dan pengeluaran tercatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambah stok: ' . $e->getMessage());
        }
    }
}
