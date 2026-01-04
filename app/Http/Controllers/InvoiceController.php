<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Request $request, Order $order)
    {
        // Allow if: Admin, Owner, or Valid Signed URL (for guests)
        $isOwner = auth()->check() && auth()->id() === $order->user_id;
        $isAdmin = auth()->check() && auth()->user()->is_admin;
        $isValidSignature = $request->hasValidSignature();

        if (!$isOwner && !$isAdmin && !$isValidSignature) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        $order->load('items.product');

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        
        return $pdf->download('Invoice-' . $order->nomor_pesanan . '.pdf');
    }
}
