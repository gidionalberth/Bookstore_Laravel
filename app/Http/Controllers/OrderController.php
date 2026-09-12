<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Checkout dari cart -> buat order + kurangi stok
    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $books = Book::whereIn('id', array_keys($cart))->lockForUpdate()->get();

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($books as $book) {
                $qty = $cart[$book->id];
                if ($book->stock < $qty) {
                    throw new \Exception('Stok buku "' . $book->title . '" tidak mencukupi.');
                }
                $total += $book->price * $qty;
            }

            $order = Order::create([
                'order_number' => 'INV-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => Order::STATUS_MENUNGGU_PEMBAYARAN,
            ]);

            foreach ($books as $book) {
                $qty = $cart[$book->id];

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'book_title' => $book->title,
                    'quantity' => $qty,
                    'price' => $book->price,
                ]);

                // Kurangi stok & tambah sold_count (dianggap terjual saat order dibuat)
                $book->decrement('stock', $qty);
                $book->increment('sold_count', $qty);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('orders.payment.show', $order)
            ->with('success', 'Pesanan dibuat. Silakan lakukan pembayaran.');
    }

    // Riwayat & dashboard pesanan milik user
    public function history()
    {
        $orders = Order::with(['items', 'payment', 'shipment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    // Struk pesanan
    public function receipt(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $order->load(['items', 'payment', 'shipment', 'user']);

        return view('orders.receipt', compact('order'));
    }
}
