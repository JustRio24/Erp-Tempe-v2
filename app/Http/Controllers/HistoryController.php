<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil order milik user yang sedang login saja
        // Urutkan dari yang terbaru (latest)
        // Paginate 10 item per halaman
        $orders = Order::where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('history.index', compact('orders'));
    }
}