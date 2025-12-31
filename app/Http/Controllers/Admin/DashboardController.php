<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductionBatch;
use App\Models\Order;
use App\Models\FinancialRecord;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        // Stock Summary
        $totalProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('is_active', true)
            ->where('stok_tersedia', '<=', config('erp.stock_warning_threshold', 10))
            ->get();
        $outOfStockProducts = Product::where('is_active', true)
            ->where('stok_tersedia', 0)
            ->count();

        // Production Summary
        $activeBatches = ProductionBatch::whereIn('status', ['Hari ke-1', 'Hari ke-2', 'Hari ke-3', 'Siap dijual'])
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        // Sales Summary
        $todayOrders =Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->whereIn('status', ['selesai'])
            ->sum('total');

        // Financial Summary
        $monthlyIncome = FinancialRecord::pemasukan()
            ->byMonth(date('Y'), date('m'))
            ->sum('jumlah');
        $monthlyExpense = FinancialRecord::pengeluaran()
            ->byMonth(date('Y'), date('m'))
            ->sum('jumlah');
        $monthlyProfit = $monthlyIncome - $monthlyExpense;

        // Weather & Recommendations
        $forecast = $this->weatherService->getForecast();
        $recommendations = $this->weatherService->getRecommendations();

        // Notifications
        $notifications = [];
        
        if ($lowStockProducts->count() > 0) {
            $notifications[] = [
                'type' => 'warning',
                'message' => $lowStockProducts->count() . ' produk stok menipis',
                'link' => route('admin.products.index'),
            ];
        }
        
        if ($outOfStockProducts > 0) {
            $notifications[] = [
                'type' => 'danger',
                'message' => $outOfStockProducts . ' produk habis',
                'link' => route('admin.products.index'),
            ];
        }
        
        if ($activeBatches->count() > 0) {
            $notifications[] = [
                'type' => 'info',
                'message' => $activeBatches->count() . ' batch produksi aktif',
                'link' => route('admin.production.index'),
            ];
        }
        
        if ($pendingOrders > 0) {
            $notifications[] = [
                'type' => 'info',
                'message' => $pendingOrders . ' pesanan menunggu diproses',
                'link' => route('admin.orders.index'),
            ];
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'activeBatches',
            'todayOrders',
            'pendingOrders',
            'todayRevenue',
            'monthlyIncome',
            'monthlyExpense',
            'monthlyProfit',
            'forecast',
            'recommendations',
            'notifications'
        ));
    }
}
