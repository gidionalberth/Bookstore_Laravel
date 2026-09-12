@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')
<h3 class="mb-3">Dashboard Pesanan Saya</h3>

@forelse($orders as $order)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6>{{ $order->order_number }}</h6>
                <span class="badge bg-secondary">{{ str_replace('_', ' ', $order->status) }}</span>
            </div>
            <p class="mb-1">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <ul class="mb-2">
                @foreach($order->items as $item)
                    <li>{{ $item->book_title }} x{{ $item->quantity }} - Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                @endforeach
            </ul>

            <p class="mb-1">
                <strong>Pembayaran:</strong>
                @if($order->payment)
                    {{ str_replace('_', ' ', $order->payment->status) }}
                @else
                    Belum upload bukti
                @endif
            </p>
            <p class="mb-1">
                <strong>Pengiriman:</strong>
                @if($order->shipment)
                    {{ str_replace('_', ' ', $order->shipment->status) }}
                    @if($order->shipment->tracking_number)
                        (No. Resi: {{ $order->shipment->tracking_number }})
                    @endif
                @else
                    Belum diisi alamat
                @endif
            </p>

            <div class="d-flex gap-2 mt-2">
                @if(!$order->payment)
                    <a href="{{ route('orders.payment.show', $order) }}" class="btn btn-sm btn-primary">Bayar Sekarang</a>
                @elseif(!$order->shipment)
                    <a href="{{ route('orders.shipping.show', $order) }}" class="btn btn-sm btn-warning">Isi Alamat Pengiriman</a>
                @endif
                <a href="{{ route('orders.receipt', $order) }}" class="btn btn-sm btn-outline-secondary">Lihat Struk</a>
            </div>
        </div>
    </div>
@empty
    <p>Belum ada pesanan.</p>
@endforelse

{{ $orders->links() }}
@endsection
