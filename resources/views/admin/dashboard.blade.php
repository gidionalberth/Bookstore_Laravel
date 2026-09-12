@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<h3 class="mb-3">Dashboard Admin</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <h6>Total Buku</h6><h3>{{ $totalBooks }}</h3>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <h6>Total Pesanan</h6><h3>{{ $totalOrders }}</h3>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm"><div class="card-body">
            <h6>Total Pendapatan</h6><h5>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h5>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm border-danger"><div class="card-body">
            <h6>Menunggu Verifikasi / Stok Habis</h6>
            <h5>{{ $pendingPayments }} / {{ $outOfStock }}</h5>
        </div></div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5>Grafik Buku Terlaris</h5>
        <canvas id="topBooksChart" height="80"></canvas>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5>Pesanan Terbaru</h5>
        <table class="table table-sm">
            <thead><tr><th>No. Pesanan</th><th>User</th><th>Total</th><th>Status</th><th>Bayar</th><th>Kirim</th><th></th></tr></thead>
            <tbody>
                @foreach($latestOrders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ str_replace('_',' ',$order->status) }}</td>
                        <td>{{ $order->payment->status ?? '-' }}</td>
                        <td>{{ $order->shipment->status ?? '-' }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('topBooksChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Terjual',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, precision: 0 } }
        }
    });
</script>
@endsection
