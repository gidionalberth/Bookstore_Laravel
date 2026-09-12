@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="row">
    <div class="col-md-4">
        <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : 'https://placehold.co/300x400?text=Buku' }}" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-8">
        <h3>{{ $book->title }}</h3>
        <p class="text-muted">{{ $book->author }}</p>
        <h4 class="text-primary">Rp {{ number_format($book->price, 0, ',', '.') }}</h4>

        @if($book->is_out_of_stock)
            <span class="badge bg-danger mb-3">Stok Habis</span>
        @else
            <span class="badge bg-success mb-3">Stok tersedia: {{ $book->stock }}</span>
        @endif

        <p>{{ $book->description }}</p>

        @auth
            @if(!auth()->user()->isAdmin())
                @unless($book->is_out_of_stock)
                    <form method="POST" action="{{ route('cart.add', $book) }}" class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}" class="form-control" style="width:100px;">
                        <button class="btn btn-primary">Tambah ke Keranjang</button>
                    </form>
                @endunless
            @endif
        @endauth
    </div>
</div>
@endsection
