<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
    public function index()
    {
        // pagination 10 per halaman, urut terbaru
        $books = Book::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ]);

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        // jika ada constraint (peminjaman), kamu bisa cek dulu apakah buku boleh dihapus
        // contoh sederhana:
        if ($book->loans()->whereNull('tanggal_dikembalikan')->exists()) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Buku masih dipinjam, tidak bisa dihapus.');
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    // optional: show() jika ingin halaman detail 
}
