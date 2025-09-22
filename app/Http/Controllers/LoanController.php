<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Riwayat peminjaman user
    public function index()
    {
        $loans = Loan::with('buku')
                     ->where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    // Store request pinjam
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'nullable|date',
            'tanggal_jatuh_tempo' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $buku = Book::findOrFail($request->buku_id);

        // Validasi stok
        if (isset($buku->jumlah_tersedia) && $buku->jumlah_tersedia < 1) {
            return back()->with('error', 'Maaf, buku ini tidak tersedia saat ini.');
        }

        // Cek ada request/peminjaman aktif sama user untuk buku ini
        $exists = Loan::where('user_id', $user->id)
                      ->where('buku_id', $buku->id)
                      ->whereIn('status', ['pending', 'dipinjam'])
                      ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah memiliki permintaan atau peminjaman aktif untuk buku ini.');
        }

        $tanggal_pinjam = $request->tanggal_pinjam ? Carbon::parse($request->tanggal_pinjam) : Carbon::now();
        $tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo ? Carbon::parse($request->tanggal_jatuh_tempo) : Carbon::now()->addWeek();

        Loan::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'status' => 'pending',
            // 'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('loans.index')->with('success', 'Permintaan pinjam berhasil dibuat. Tunggu konfirmasi admin.');
    }
}
