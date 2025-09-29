<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; // boleh tetap kalau kamu pakai
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rapi & terstruktur: root -> /login ; group untuk auth & admin.
|
*/

//
// 1) Root: langsung ke halaman login
//
Route::redirect('/', '/login');

//
// 2) Auth routes (Breeze / Fortify)
//
require __DIR__ . '/auth.php';

//
// 3) Helper: redirect setelah login (gunakan middleware auth)
//    — dipakai jika kamu memanggil route ini dari controller/login redirect
//
Route::get('/redirect-after-login', function () {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('dashboard');
})->middleware('auth');

//
// 4) Routes untuk pengguna terautentikasi (user biasa)
//
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // resources/views/dashboard.blade.php
    })->name('dashboard');

    // Books (user)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // User loans (riwayat & pinjam)
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
});

//
// 5) Admin routes (prefix: /admin) — semua middleware auth + is_admin
//    Kumpulkan semua route admin di satu group agar rapi
//
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->name('admin.')
    ->group(function () {

        // Admin dashboard (gunakan controller DashboardController::index)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Buku (resource controller)
        Route::resource('books', BooksController::class);

        // Admin loans: list, detail, approve, reject, return
        Route::get('/loans', [AdminLoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/{loan}', [AdminLoanController::class, 'show'])->name('loans.show');

        Route::post('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
        Route::post('/loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('loans.reject');
        Route::post('/loans/{loan}/return', [AdminLoanController::class, 'markReturned'])->name('loans.return');

        // (opsional) jika ada controller lain seperti AdminController, daftarkan di sini
        // Route::get('/other', [AdminController::class, 'otherMethod'])->name('other');
    });
