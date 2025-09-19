<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_dikembalikan',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function buku()
    {
        // Pastikan Model Book bernama App\Models\Book
        return $this->belongsTo(\App\Models\Book::class, 'buku_id');
    }

    // (Opsional) casting tanggal
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_jatuh_tempo' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
    ];
}
