<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Daftar semua pesanan + status pembayaran & pengiriman
    public function index(Request $request)
    {
        $status = $request->get('status');

        $orders = Order::with(['user', 'items', 'payment', 'shipment'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.book', 'payment', 'shipment']);

        return view('admin.orders.show', compact('order'));
    }

    // Admin verifikasi bukti pembayaran (diterima/ditolak)
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'decision' => ['required', 'in:diterima,ditolak'],
        ]);

        $order->payment()->update(['status' => $request->decision]);

        if ($request->decision === 'diterima') {
            $order->update(['status' => Order::STATUS_DIPROSES]);
            $message = 'Pembayaran diterima. Pesanan diproses.';
        } else {
            $order->update(['status' => Order::STATUS_MENUNGGU_PEMBAYARAN]);
            $message = 'Pembayaran ditolak. Menunggu pembayaran ulang dari user.';
        }

        return back()->with('success', $message);
    }

    // Admin ubah status pengiriman
    public function updateShipment(Request $request, Order $order)
    {
        $request->validate([
            'shipment_status' => ['required', 'in:menunggu,dikemas,dikirim,diterima'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        $order->shipment()->update([
            'status' => $request->shipment_status,
            'tracking_number' => $request->tracking_number,
        ]);

        // Sinkronkan status order utama
        $orderStatus = match ($request->shipment_status) {
            'dikirim' => Order::STATUS_DIKIRIM,
            'diterima' => Order::STATUS_SELESAI,
            default => Order::STATUS_DIPROSES,
        };
        $order->update(['status' => $orderStatus]);

        return back()->with('success', 'Status pengiriman diperbarui.');
    }
}
