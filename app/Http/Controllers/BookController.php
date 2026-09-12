<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Daftar buku untuk user, bisa dicari
    public function index(Request $request)
    {
        $keyword = $request->get('q');

        $books = Book::search($keyword)
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('books.index', compact('books', 'keyword'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
