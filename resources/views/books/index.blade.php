@extends('layouts.app')
@section('title', 'Daftar Buku')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Buku</h3>
    <form method="GET" action="{{ route('books.index') }}" class="d-flex" style="max-width:300px;">
        <input type="text" name="q" value="{{ $keyword }}" class="form-control me-2" placeholder="Cari judul / penulis...">
        <button class="btn btn-outline-primary">Cari</button>
    </form>
</div>

<div class="row g-4">
    @forelse ($books as $book)
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : 'https://placehold.co/300x400?text=Buku' }}" class="card-img-top" style="height:220px;object-fit:cover;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">{{ $book->title }}</h6>
                    <p class="text-muted small mb-1">{{ $book->author }}</p>
                    <p class="fw-bold mb-1">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                    @if($book->is_out_of_stock)
                        <span class="badge bg-danger mb-2">Stok Habis</span>
                    @else
                        <span class="badge bg-success mb-2">Stok: {{ $book->stock }}</span>
                    @endif
                    <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-primary mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>
    @empty
        <p>Tidak ada buku ditemukan.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $books->links() }}
</div>
@endsection
