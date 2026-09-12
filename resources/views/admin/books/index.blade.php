@extends('layouts.app')
@section('title', 'Kelola Buku')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Kelola Buku</h3>
    <a href="{{ route('admin.books.create') }}" class="btn btn-success">+ Tambah Buku</a>
</div>

<form method="GET" class="mb-3" style="max-width:300px;">
    <input type="text" name="q" class="form-control" placeholder="Cari buku..." value="{{ request('q') }}">
</form>

<table class="table bg-white">
    <thead><tr><th>Cover</th><th>Judul</th><th>Harga</th><th>Stok</th><th>Terjual</th><th></th></tr></thead>
    <tbody>
        @foreach($books as $book)
            <tr>
                <td><img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : 'https://placehold.co/60x80' }}" style="height:60px;"></td>
                <td>{{ $book->title }}<br><small class="text-muted">{{ $book->author }}</small></td>
                <td>Rp {{ number_format($book->price,0,',','.') }}</td>
                <td>
                    @if($book->is_out_of_stock)
                        <span class="badge bg-danger">Habis</span>
                    @else
                        {{ $book->stock }}
                    @endif
                </td>
                <td>{{ $book->sold_count }}</td>
                <td>
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline" onsubmit="return confirm('Hapus buku ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $books->links() }}
@endsection
