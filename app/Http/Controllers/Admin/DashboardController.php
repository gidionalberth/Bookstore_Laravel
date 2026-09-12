<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['diproses', 'dikirim', 'selesai'])->sum('total_price');
        $pendingPayments = Payment::where('status', 'menunggu_verifikasi')->count();
        $outOfStock = Book::where('stock', '<=', 0)->count();

        // Data untuk grafik buku terlaris (top 10)
        $topBooks = Book::orderByDesc('sold_count')
            ->take(10)
            ->get(['title', 'sold_count']);

        $chartLabels = $topBooks->pluck('title');
        $chartData = $topBooks->pluck('sold_count');

        $latestOrders = Order::with(['user', 'payment', 'shipment'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'totalRevenue',
            'pendingPayments',
            'outOfStock',
            'chartLabels',
            'chartData',
            'latestOrders'
        ));
    }
}
