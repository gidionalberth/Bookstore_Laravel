<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    // Form alamat + catatan pengiriman, diisi setelah user membayar
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        return view('orders.shipping', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $data = $request->validate([
            'address' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        Shipment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
                'status' => 'menunggu',
            ]
        );

        return redirect()->route('orders.history')
            ->with('success', 'Alamat pengiriman disimpan. Menunggu verifikasi admin.');
    }
}
