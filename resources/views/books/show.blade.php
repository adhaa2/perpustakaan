<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $book->judul }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 flex flex-col sm:flex-row gap-6">
                <div class="sm:w-1/3">
                    @if(!empty($book->path_sampul))
                        <img src="{{ asset('storage/'.$book->path_sampul) }}" alt="Sampul {{ $book->judul }}" class="w-full h-auto rounded">
                    @else
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400 rounded">
                            Tidak ada sampul
                        </div>
                    @endif
                </div>

                <div class="sm:flex-1">
                    <h3 class="text-2xl font-bold mb-2">{{ $book->judul }}</h3>
                    <p class="text-sm text-gray-700 mb-2"><strong>Pengarang:</strong> {{ $book->pengarang ?? '—' }}</p>
                    <p class="text-sm text-gray-700 mb-2"><strong>Penerbit:</strong> {{ $book->penerbit ?? '—' }}</p>
                    <p class="text-sm text-gray-700 mb-2"><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit ?? '—' }}</p>

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
                            <form action="#" method="POST" onsubmit="alert('Fitur pinjam belum diimplementasikan.'); return false;">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Pinjam</button>
                            </form>
                        </div>
                    @else
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Login untuk pinjam</a>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('books.index') }}" class="text-gray-600">&larr; Kembali ke daftar buku</a>
            </div>
        </div>
    </div>
</x-app-layout>
