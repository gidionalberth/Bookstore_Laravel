<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Cart sederhana disimpan di session: [book_id => qty]
    public function index()
    {
        $cart = session('cart', []);
        $books = Book::whereIn('id', array_keys($cart))->get();

        $items = $books->map(function ($book) use ($cart) {
            return [
                'book' => $book,
                'qty' => $cart[$book->id],
                'subtotal' => $book->price * $cart[$book->id],
            ];
        });

        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Book $book)
    {
        $qty = (int) $request->input('quantity', 1);
        $qty = max(1, $qty);

        if ($book->stock < $qty) {
            return back()->with('error', 'Stok buku "' . $book->title . '" tidak mencukupi.');
        }

        $cart = session('cart', []);
        $cart[$book->id] = ($cart[$book->id] ?? 0) + $qty;
        session(['cart' => $cart]);

        return back()->with('success', 'Buku ditambahkan ke keranjang.');
    }

    public function remove(Book $book)
    {
        $cart = session('cart', []);
        unset($cart[$book->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Buku dihapus dari keranjang.');
    }
}
