<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // Tampilkan daftar buku (dengan search & pagination)
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Book::query();

        // support soft deletes: only visible jika tidak soft deleted
        // (Eloquent default sudah exclude soft-deleted if SoftDeletes used)

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('pengarang', 'like', "%{$q}%")
                    ->orWhere('penerbit', 'like', "%{$q}%");
            });
        }

        // eager load count of loans (optional) to avoid N+1
        $books = $query->orderBy('created_at', 'desc')
                       ->withCount('loans')
                       ->paginate(12)
                       ->withQueryString();

        return view('books.index', compact('books', 'q'));
    }

    // Tampilkan halaman detail buku
    public function show(Book $book)
    {
        // jika pakai soft deletes dan ingin 404 bila soft deleted: default route model binding sudah handle
        return view('books.show', compact('book'));
    }
}
