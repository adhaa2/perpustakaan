<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahUsers = User::count();
        $jumlahBuku = Book::count();
        $jumlahPeminjaman = Loan::count();

        $peminjamanAktif = Loan::where('status','dipinjam')->count();
        $peminjamanPending = Loan::where('status','pending')->count();

        $overdue = Loan::where('status','dipinjam')
                       ->where('tanggal_jatuh_tempo','<', now())
                       ->count();

        $topBuku = Book::withCount('loans')->orderByDesc('loans_count')->take(5)->get();

        $peminjamanTerakhir = Loan::with(['user','buku'])->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'jumlahUsers','jumlahBuku','jumlahPeminjaman',
            'peminjamanAktif','peminjamanPending','overdue',
            'topBuku','peminjamanTerakhir'
        ));
    }
}
