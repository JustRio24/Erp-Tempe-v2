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
        
        $monthlyCogs = Order::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->whereIn('status', ['selesai', 'diproses', 'dikirim'])
            ->sum('hpp_total');
            
        $monthlyGrossProfit = $monthlyIncome - $monthlyCogs;
        $monthlyNetProfit = $monthlyIncome - $monthlyExpense;

        // Weather & Decision Engine
        $forecast = $this->weatherService->getForecast();
        $todayWeather = $forecast[0] ?? null;
        $weatherRecommendations = [];

        if ($todayWeather) {
            $classification = $todayWeather['klasifikasi'];
            $isRainy = ($todayWeather['presipitasi'] ?? 0) > 0 || str_contains(strtolower($todayWeather['kondisi'] ?? ''), 'hujan');
            
            // A. PRODUCTION RULES
            foreach ($activeBatches as $batch) {
                if ($classification === 'Dingin / Lembab') {
                    if ($batch->hari_ke <= 2) {
                        $weatherRecommendations[] = [
                            'type' => 'warning',
                            'icon' => '🌡️',
                            'message' => 'Cuaca dingin dapat memperlambat fermentasi. Periksa kondisi tempe lebih sering agar tidak gagal.'
                        ];
                    } elseif ($batch->hari_ke == 3) {
                        $weatherRecommendations[] = [
                            'type' => 'warning',
                            'icon' => '🌫️',
                            'message' => 'Fermentasi berisiko tidak merata. Perhatikan kepadatan dan aroma tempe.'
                        ];
                    }
                }

                if ($classification === 'Panas') {
                    if ($batch->hari_ke >= 2 && $batch->hari_ke <= 3) {
                        $weatherRecommendations[] = [
                            'type' => 'info',
                            'icon' => '🔥',
                            'message' => 'Cuaca panas dapat mempercepat fermentasi. Batch ini berpotensi lebih cepat siap jual.'
                        ];
                    }
                    if ($batch->status === 'Siap dijual') {
                        $weatherRecommendations[] = [
                            'type' => 'danger',
                            'icon' => '⚠️',
                            'message' => 'Tempe berisiko cepat rusak. Prioritaskan penjualan batch ini.'
                        ];
                    }
                }
            }

            // New batch started today check
            $newBatchesStarted = \App\Models\ProductionBatch::whereDate('tanggal_mulai', today())->count();
            if ($classification === 'Dingin / Lembab' && $newBatchesStarted > 0) {
                $weatherRecommendations[] = [
                    'type' => 'warning',
                    'icon' => '💧',
                    'message' => 'Udara lembab dapat mempengaruhi kualitas kedelai. Pastikan kedelai cukup kering sebelum produksi.'
                ];
            }

            // B. SALES & DISTRIBUTION RULES
            if ($isRainy && $pendingOrders > 0) {
                $weatherRecommendations[] = [
                    'type' => 'warning',
                    'icon' => '🌧️',
                    'message' => 'Hujan dapat menghambat distribusi. Pastikan pengiriman tidak terlambat.'
                ];
            }

            $totalStock = Product::sum('stok_tersedia');
            $isStockHigh = $totalStock > config('erp.high_stock_threshold', 100);

            if ($classification === 'Dingin / Lembab' && $isStockHigh) {
                $weatherRecommendations[] = [
                    'type' => 'success',
                    'icon' => '🍳',
                    'message' => 'Cuaca dingin biasanya meningkatkan permintaan tempe goreng. Peluang penjualan meningkat.'
                ];
            }

            if ($classification === 'Panas' && $isStockHigh) {
                $weatherRecommendations[] = [
                    'type' => 'warning',
                    'icon' => '📉',
                    'message' => 'Cuaca panas cenderung menurunkan permintaan. Pertimbangkan mengurangi produksi berikutnya.'
                ];
            }

            // Logging (Optional but recommended)
            \App\Models\WeatherLog::updateOrCreate(
                ['tanggal' => today()],
                [
                    'suhu' => $todayWeather['suhu_avg'] ?? 0,
                    'kelembaban' => $todayWeather['kelembaban'] ?? 0,
                    'klasifikasi' => $classification,
                    'notifikasi' => $weatherRecommendations
                ]
            );
        }

        // Inventory & Supply Chain Smart Alerts
        $inventoryAlerts = [];
        $materials = \App\Models\Material::all();
        $dailyKedelaiUsage = 150; 

        foreach ($materials as $material) {
            if (str_contains(strtolower($material->nama), 'kedelai')) {
                $daysLeft = $material->stok_tersedia / ($dailyKedelaiUsage ?: 1);
                if ($daysLeft <= 3) {
                    $inventoryAlerts[] = [
                        'type' => 'danger',
                        'icon' => '🌾',
                        'message' => "Stok KEDELAI tinggal " . round($material->stok_tersedia) . "kg. Estimasi HABIS dalam " . round($daysLeft, 1) . " hari produksi!"
                    ];
                } elseif ($daysLeft <= 7) {
                    $inventoryAlerts[] = [
                        'type' => 'warning',
                        'icon' => '🌾',
                        'message' => "Stok Kedelai Cukup untuk " . round($daysLeft, 1) . " hari ke depan."
                    ];
                }
            } elseif ($material->stok_tersedia <= $material->stok_minimal) {
                $inventoryAlerts[] = [
                    'type' => 'warning',
                    'icon' => '📦',
                    'message' => "Stok {$material->nama} di bawah batas minimal ({$material->stok_tersedia} {$material->satuan})."
                ];
            }
        }

        // Price Trend Analysis (Kedelai)
        $kedelai = \App\Models\Material::where('nama', 'LIKE', '%Kedelai%')->first();
        $kedelaiTrend = [];
        if ($kedelai) {
            $kedelaiTrend = \App\Models\MaterialMovement::where('material_id', $kedelai->id)
                ->where('tipe', 'masuk')
                ->whereNotNull('harga_satuan')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->reverse()
                ->values();
        }

        // System Notifications
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
            'monthlyCogs',
            'monthlyGrossProfit',
            'monthlyNetProfit',
            'kedelaiTrend',
            'kedelai',
            'forecast',
            'weatherRecommendations',
            'inventoryAlerts',
            'notifications'
        ));
    }
}
