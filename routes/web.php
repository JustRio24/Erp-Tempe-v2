<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\InvoiceController;
use App\Models\Order;


// Customer-facing routes
Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/produk', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/produk/{product}', [CatalogController::class, 'show'])->name('catalog.show');

// Cart routes (session-based, no auth required)
Route::prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/tambah/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/hapus/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/kosongkan', [CartController::class, 'clear'])->name('clear');
});

// Checkout routes (no auth required)
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/proses', [CheckoutController::class, 'process'])->name('process');
    Route::get('/sukses/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Admin routes (protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product & Inventory Management
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/adjust-stock', [ProductController::class, 'adjustStock'])->name('products.adjust-stock');
    
    // Production Management
    Route::resource('production', ProductionController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('production/{production}/advance', [ProductionController::class, 'advanceDay'])->name('production.advance');
    Route::post('production/{production}/complete', [ProductionController::class, 'complete'])->name('production.complete');
    Route::post('production/{production}/record-failure', [ProductionController::class, 'recordFailure'])->name('production.record-failure');
    
    // Order Management
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Finance Management
    Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('finance/laporan', [FinanceController::class, 'reports'])->name('finance.reports');
    Route::get('finance/laporan/pdf', [FinanceController::class, 'exportPdf'])->name('finance.reports.pdf');
    Route::post('finance/pengeluaran', [FinanceController::class, 'storeExpense'])->name('finance.store-expense');

    // Material Management
    Route::resource('materials', MaterialController::class);
    Route::post('materials/{material}/restock', [MaterialController::class, 'restock'])->name('materials.restock');

    // BOM Management (nested under products for clarity)
    Route::get('products/{product}/bom', [ProductController::class, 'bom'])->name('products.bom');
    Route::post('products/{product}/bom', [ProductController::class, 'updateBom'])->name('products.update-bom');

    // Order Contact Redirect
    Route::get('orders/{order}/contact', function (Order $order) {
        $phone = $order->telepon_pembeli;
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $message = "Halo " . $order->nama_pembeli . ", kami dari Tempe 3 Puteri ingin mengkonfirmasi pesanan #" . $order->nomor_pesanan;
        return redirect()->away("https://wa.me/" . $phone . "?text=" . urlencode($message));
    })->name('orders.contact');
});

// Public/Auth shared (Guests can access via Signed URLs)
Route::get('/pesanan/{order}/invoice', [InvoiceController::class, 'download'])->name('orders.invoice');

// Breeze default dashboard redirect
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Breeze profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // ... route lain ...
    
    // Route Riwayat
    Route::get('/riwayat-pesanan', [HistoryController::class, 'index'])->name('history.index');
});

require __DIR__.'/auth.php';
