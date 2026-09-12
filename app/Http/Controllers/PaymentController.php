<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        return view('orders.payment', compact('order'));
    }

    // Upload bukti pembayaran
    public function store(Request $request, Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $request->validate([
            'proof_image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'proof_image' => $path,
                'status' => 'menunggu_verifikasi',
                'paid_at' => now(),
            ]
        );

        $order->update(['status' => Order::STATUS_MENUNGGU_VERIFIKASI]);

        return redirect()->route('orders.shipping.show', $order)
            ->with('success', 'Bukti pembayaran terkirim. Silakan lengkapi alamat pengiriman.');
    }
}
