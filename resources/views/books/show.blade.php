<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $book->judul }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 flex flex-col sm:flex-row gap-6">
                <div class="sm:w-1/3">
                        @if(!empty($book->path_sampul))
                            <img src="{{ $book->path_sampul }}" 
                            alt="Sampul {{ $book->judul }}" 
                            class="h-50 w-full object-contain rounded mb-3 bg-gray-50 p-1">
                        @else
                            <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400 rounded mb-3">
                                Tidak ada sampul
                            </div>
                        @endif
                </div>

                    <div class="sm:flex-1">
                        <h3 class="text-2xl font-bold mb-2">{{ $book->judul }}</h3>
                        <p class="text-sm text-gray-700 mb-2"><strong>Pengarang:</strong> {{ $book->pengarang ?? '—' }}
                        </p>
                        <p class="text-sm text-gray-700 mb-2"><strong>Penerbit:</strong> {{ $book->penerbit ?? '—' }}
                        </p>
                        <p class="text-sm text-gray-700 mb-2"><strong>Tahun Terbit:</strong>
                            {{ $book->tahun_terbit ?? '—' }}</p>

                        <p class="text-sm text-gray-700 mb-4"><strong>Stok / Tersedia:</strong>
                            {{ $book->stok ?? $book->jumlah_tersedia ?? '—' }}
                        </p>

                        @if(!empty($book->deskripsi))
                            <div class="prose max-w-none text-gray-700 mb-4">
                                {!! nl2br(e($book->deskripsi)) !!}
                            </div>
                        @endif

                        <!-- tombol pinjam: tampilkan kondisi (optional, belum diimplementasi) -->
                        @auth
                            <div class="mt-4">
                                <form action="{{ route('loans.store') }}" method="POST" class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="buku_id" value="{{ $book->id }}">

                                    <div class="flex gap-2">
                                        <input type="date" name="tanggal_pinjam" class="border rounded p-2"
                                            value="{{ now()->toDateString() }}">
                                        <input type="date" name="tanggal_jatuh_tempo" class="border rounded p-2"
                                            value="{{ now()->addWeek()->toDateString() }}">
                                    </div>

                                    <!-- <div>
                                        <textarea name="keterangan" rows="2" class="w-full border rounded p-2"
                                            placeholder="Keterangan (opsional)"></textarea>
                                    </div> -->

                                    <button type="submit" class="px-4 py-2 bg-green-600 text-black rounded"
                                        onclick="return confirm('Kirim permintaan pinjam?');">
                                        Pinjam
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-4">
                                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-black rounded">Login untuk
                                    pinjam</a>
                            </div>
                        @endauth


                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        ← Kembali ke menu buku
                    </a>
                </div>
            </div>
        </div>
</x-app-layout>