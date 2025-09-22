<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ke users.id
            $table->foreignId('buku_id')->constrained('books')->onDelete('restrict'); // ke books.id
            $table->date('tanggal_pinjam')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_dikembalikan')->nullable();
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'terlambat', 'ditolak'])
                ->default('pending');

            $table->timestamps();

            $table->index('user_id');
            $table->index('buku_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
