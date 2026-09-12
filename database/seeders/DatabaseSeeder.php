<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@tokobuku.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User Contoh',
            'email' => 'user@tokobuku.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $books = [
            ['title' => 'BITCOIN', 'author' => 'RDr. I Gusti Kade Budhi', 'price' => 199000, 'stock' => 10, 'cover_image' => 'book_covers\bitcoin.jpg'],
            ['title' => 'Peonys WORLD', 'author' => 'Kezia Evi Widiaji', 'price' => 150000, 'stock' => 5,'cover_image' => 'book_covers\peony.jpg'],
       
        ];

        foreach ($books as $book) {
            Book::create(array_merge($book, [
                'description' => 'Deskripsi contoh untuk buku ' . $book['title'] . '.',
            ]));
        }
    }
}
