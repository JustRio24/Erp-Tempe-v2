<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        $today = today();
        $thisMonth = now()->month;
        $thisYear = now()->year;

        // Today's summary
        $todayIncome = FinancialRecord::pemasukan()
            ->whereDate('tanggal', $today)
            ->sum('jumlah');
        $todayExpense = FinancialRecord::pengeluaran()
            ->whereDate('tanggal', $today)
            ->sum('jumlah');

        // This month's summary
        $monthlyIncome = FinancialRecord::pemasukan()
            ->byMonth($thisYear, $thisMonth)
            ->sum('jumlah');
        $monthlyExpense = FinancialRecord::pengeluaran()
            ->byMonth($thisYear, $thisMonth)
            ->sum('jumlah');

        // Recent transactions
        $recentRecords = FinancialRecord::orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.finance.index', compact(
            'todayIncome',
            'todayExpense',
            'monthlyIncome',
            'monthlyExpense',
            'recentRecords'
        ));
    }

    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $income = FinancialRecord::pemasukan()
            ->byDateRange($startDate, $endDate)
            ->orderBy('tanggal')
            ->get();
        
        $expenses = FinancialRecord::pengeluaran()
            ->byDateRange($startDate, $endDate)
            ->orderBy('tanggal')
            ->get();

        $totalIncome = $income->sum('jumlah');
        $totalExpense = $expenses->sum('jumlah');
        $profit = $totalIncome - $totalExpense;

        // Group by category
        $expensesByCategory = $expenses->groupBy('kategori')->map(function ($items) {
            return $items->sum('jumlah');
        });

        return view('admin.finance.reports', compact(
            'income',
            'expenses',
            'totalIncome',
            'totalExpense',
            'profit',
            'expensesByCategory',
            'startDate',
            'endDate'
        ));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'required|string|max:500',
        ]);

        FinancialRecord::create([
            'tanggal' => $request->tanggal,
            'tipe' => 'pengeluaran',
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'referensi_tipe' => 'manual',
        ]);

        return back()->with('success', 'Pengeluaran berhasil dicatat');
    }
}
