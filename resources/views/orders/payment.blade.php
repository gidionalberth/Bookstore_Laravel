@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Pembayaran Pesanan {{ $order->order_number }}</h5>
                <p>Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
                <p class="text-muted">Silakan transfer ke rekening BCA 1234567890 a.n Toko Buku, lalu upload bukti transfer di bawah ini.</p>

                <form method="POST" action="{{ route('orders.payment.store', $order) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" name="proof_image" class="form-control" accept="image/*" required>
                    </div>
                    <button class="btn btn-primary w-100">Kirim Bukti Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
