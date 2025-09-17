<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'judul' => 'Belajar Laravel 101',
            'pengarang' => 'Adi Dev',
            'penerbit' => 'Penerbit Contoh',
            'tahun_terbit' => 2024,
            'stok' => 3,
        ]);
    }
}
