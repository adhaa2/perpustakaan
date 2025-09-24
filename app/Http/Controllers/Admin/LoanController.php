<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

 
    public function index(Request $request)
    {
        $status = $request->get('status'); // optional: ?status=pending
        $q = trim($request->get('q')); // optional search query
        $query = Loan::with('buku','user')->orderBy('created_at','desc');

        if ($status) $query->where('status', $status);

        if ($q) {
            $query->whereHas('buku', function($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('pengarang', 'like', "%{$q}%")
                    ->orWhere('penerbit', 'like', "%{$q}%");
            })->orWhereHas('user', function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }
        $loans = $query->paginate(15)->withQueryString();

        return view('admin.loans.index', compact('loans','status', 'q'));
    }

    // 2) tampilan detail pinjaman (opsional)
    public function show(Loan $loan)
    {
        $loan->load('buku','user');
        return view('admin.loans.show', compact('loan', 'q'));
    }

    // 3) Approve => ubah status menjadi dipinjam + kurangi stok
    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Hanya request dengan status pending yang bisa di-approve.');
        }

        DB::beginTransaction();
        try {
            // lock buku untuk menghindari race condition
            $book = Book::where('id', $loan->buku_id)->lockForUpdate()->first();

            if (!$book) throw new \Exception('Buku tidak ditemukan.');

            // cari kolom stok (fallback)
            $available = $book->jumlah_tersedia ?? $book->stok ?? $book->jumlah_total ?? null;

            if ($available === null) {
                throw new \Exception('Kolom stok buku tidak ditemukan (jumlah_tersedia/stok).');
            }

            if ((int)$available < 1) {
                throw new \Exception('Stok buku tidak mencukupi untuk dipinjam.');
            }

            // kurangi stok
            if (isset($book->jumlah_tersedia)) {
                $book->jumlah_tersedia = (int)$book->jumlah_tersedia - 1;
            } elseif (isset($book->stok)) {
                $book->stok = (int)$book->stok - 1;
            } else {
                $book->jumlah_total = (int)$book->jumlah_total - 1;
            }
            $book->save();

            // update loan
            $loan->status = 'dipinjam';
            if (!$loan->tanggal_pinjam) $loan->tanggal_pinjam = now();
            $loan->save();

            DB::commit();
            return redirect()->route('admin.loans.index')->with('success','Permintaan disetujui dan stok dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Approve loan failed: '.$e->getMessage());
            return back()->with('error','Gagal approve: '.$e->getMessage());
        }
    }

    // 4) Tolak request => set status ditolak
    public function reject(Loan $loan, Request $request)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error','Hanya request pending yang bisa ditolak.');
        }

        $loan->status = 'ditolak';
        // optional: simpan alasan penolakan ke keterangan atau kolom khusus
        if ($request->filled('alasan')) {
            $loan->keterangan = 'Ditolak: '.$request->alasan;
        }
        $loan->save();

        return redirect()->route('admin.loans.index')->with('success','Permintaan ditolak.');
    }

    // 5) Tandai dikembalikan => tambah stok + set tanggal_dikembalikan
    public function markReturned(Loan $loan)
    {
        if ($loan->status !== 'dipinjam') {
            return back()->with('error','Hanya pinjaman yang sedang dipinjam yang bisa ditandai dikembalikan.');
        }

        DB::beginTransaction();
        try {
            $book = Book::where('id', $loan->buku_id)->lockForUpdate()->first();

            if (!$book) throw new \Exception('Buku tidak ditemukan.');

            // tambah stok
            if (isset($book->jumlah_tersedia)) {
                $book->jumlah_tersedia = (int)$book->jumlah_tersedia + 1;
            } elseif (isset($book->stok)) {
                $book->stok = (int)$book->stok + 1;
            } else {
                $book->jumlah_total = (int)$book->jumlah_total + 1;
            }
            $book->save();

            $loan->status = 'dikembalikan';
            $loan->tanggal_dikembalikan = now();
            $loan->save();

            DB::commit();
            return redirect()->route('admin.loans.index')->with('success','Buku ditandai sebagai dikembalikan dan stok di-update.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Return loan failed: '.$e->getMessage());
            return back()->with('error','Gagal tandai dikembalikan: '.$e->getMessage());
        }
    }
}
