@extends('layouts.app')
@section('title', $book->exists ? 'Edit Buku' : 'Tambah Buku')
@section('content')
<h3 class="mb-3">{{ $book->exists ? 'Edit Buku' : 'Tambah Buku' }}</h3>

<form method="POST" action="{{ $book->exists ? route('admin.books.update', $book) : route('admin.books.store') }}" enctype="multipart/form-data">
    @csrf
    @if($book->exists) @method('PUT') @endif

    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Penulis</label>
        <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $book->description) }}</textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Harga</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $book->price) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock) }}" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Cover Buku</label>
        <input type="file" name="cover_image" class="form-control" accept="image/*">
        @if($book->cover_image)
            <img src="{{ asset('storage/'.$book->cover_image) }}" style="height:80px;" class="mt-2">
        @endif
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
