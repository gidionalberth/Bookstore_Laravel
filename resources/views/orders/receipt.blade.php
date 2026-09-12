@extends('layouts.app')
@section('title', 'Struk Pesanan')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="text-center mb-3">STRUK PEMBELIAN</h5>
                <p class="mb-1"><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
                <p class="mb-1"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-1"><strong>Pembeli:</strong> {{ $order->user->name }}</p>
                <hr>
                <table class="table table-sm">
                    <thead><tr><th>Buku</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->book_title }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <h6 class="text-end">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h6>
                <p class="text-end">Status: {{ str_replace('_', ' ', $order->status) }}</p>
                <button onclick="window.print()" class="btn btn-outline-primary w-100 mt-2">Cetak Struk</button>
            </div>
        </div>
    </div>
</div>
@endsection
