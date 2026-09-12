@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
<h3 class="mb-3">Detail Pesanan {{ $order->order_number }}</h3>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5>Item Pesanan</h5>
                <p>Pembeli: {{ $order->user->name }} ({{ $order->user->email }})</p>
                <ul>
                    @foreach($order->items as $item)
                        <li>{{ $item->book_title }} x{{ $item->quantity }} - Rp {{ number_format($item->subtotal,0,',','.') }}</li>
                    @endforeach
                </ul>
                <h6>Total: Rp {{ number_format($order->total_price,0,',','.') }}</h6>
                <p>Status pesanan: <strong>{{ str_replace('_',' ',$order->status) }}</strong></p>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5>Bukti Pembayaran</h5>
                @if($order->payment)
                    <img src="{{ asset('storage/'.$order->payment->proof_image) }}" class="img-fluid mb-2" style="max-height:300px;">
                    <p>Status saat ini: <strong>{{ $order->payment->status }}</strong></p>
                    @if($order->payment->status === 'menunggu_verifikasi')
                        <form method="POST" action="{{ route('admin.orders.verifyPayment', $order) }}" class="d-flex gap-2">
                            @csrf
                            <button name="decision" value="diterima" class="btn btn-success btn-sm">Terima</button>
                            <button name="decision" value="ditolak" class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    @endif
                @else
                    <p class="text-muted">User belum upload bukti pembayaran.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Pengiriman</h5>
                @if($order->shipment)
                    <p><strong>Alamat:</strong> {{ $order->shipment->address }}</p>
                    <p><strong>Catatan dari user:</strong> {{ $order->shipment->note ?: '-' }}</p>

                    <form method="POST" action="{{ route('admin.orders.updateShipment', $order) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Status Pengiriman</label>
                            <select name="shipment_status" class="form-select">
                                @foreach(['menunggu','dikemas','dikirim','diterima'] as $s)
                                    <option value="{{ $s }}" {{ $order->shipment->status==$s?'selected':'' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">No. Resi (opsional)</label>
                            <input type="text" name="tracking_number" class="form-control" value="{{ $order->shipment->tracking_number }}">
                        </div>
                        <button class="btn btn-primary">Update Status Pengiriman</button>
                    </form>
                @else
                    <p class="text-muted">User belum mengisi alamat pengiriman.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
