@extends('layouts.app')
@section('title', 'Alamat Pengiriman')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Alamat Pengiriman - Pesanan {{ $order->order_number }}</h5>
                <form method="POST" action="{{ route('orders.shipping.store', $order) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $order->shipment->address ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Pengiriman (opsional)</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Contoh: kirim sore hari, titip ke satpam, dll.">{{ old('note', $order->shipment->note ?? '') }}</textarea>
                    </div>
                    <button class="btn btn-primary w-100">Simpan Alamat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
