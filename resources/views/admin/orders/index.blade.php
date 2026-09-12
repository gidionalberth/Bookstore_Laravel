@extends('layouts.app')
@section('title', 'Kelola Pesanan')
@section('content')
<h3 class="mb-3">Kelola Pesanan</h3>

<form method="GET" class="mb-3" style="max-width:300px;">
    <select name="status" class="form-select" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach(['menunggu_pembayaran','menunggu_verifikasi','diproses','dikirim','selesai','dibatalkan'] as $s)
            <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ str_replace('_',' ',$s) }}</option>
        @endforeach
    </select>
</form>

<table class="table bg-white">
    <thead><tr><th>No. Pesanan</th><th>User</th><th>Total</th><th>Status</th><th>Bayar</th><th>Kirim</th><th></th></tr></thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name }}</td>
                <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                <td>{{ str_replace('_',' ',$order->status) }}</td>
                <td>{{ $order->payment->status ?? '-' }}</td>
                <td>{{ $order->shipment->status ?? '-' }}</td>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection
