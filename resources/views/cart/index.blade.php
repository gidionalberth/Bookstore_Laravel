@extends('layouts.app')
@section('title', 'Keranjang')
@section('content')
<h3 class="mb-3">Keranjang Belanja</h3>

@if($items->isEmpty())
    <p>Keranjang masih kosong. <a href="{{ route('books.index') }}">Cari buku</a></p>
@else
    <table class="table bg-white">
        <thead>
            <tr>
                <th>Buku</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['book']->title }}</td>
                    <td>Rp {{ number_format($item['book']->price, 0, ',', '.') }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $item['book']) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <h5>Total: Rp {{ number_format($total, 0, ',', '.') }}</h5>
        <form method="POST" action="{{ route('orders.checkout') }}">
            @csrf
            <button class="btn btn-success">Checkout</button>
        </form>
    </div>
@endif
@endsection
