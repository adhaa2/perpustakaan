<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Buku</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- search -->
            <form action="{{ route('books.index') }}" method="GET" class="mb-6">
                <div class="flex gap-2">
                    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari judul, pengarang, penerbit..." class="w-full border rounded p-2">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($books as $book)
                    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                        <!-- @if(!empty($book->path_sampul))
                            <img src="{{ asset('storage/'.$book->path_sampul) }}" alt="Sampul {{ $book->judul }}" class="h-48 w-full object-cover rounded mb-3">
                        @else
                            <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400 rounded mb-3">
                                Tidak ada sampul
                            </div>
                        @endif -->

                        <h3 class="font-semibold text-lg">{{ $book->judul }}</h3>
                        <p class="text-sm text-gray-600">{{ $book->pengarang ?? '—' }}</p>
                        <p class="text-sm text-gray-500 mt-2">Penerbit: {{ $book->penerbit ?? '—' }}</p>
                        <div class="mt-auto flex items-center justify-between">
                            <div class="text-sm text-gray-700">Tahun: {{ $book->tahun_terbit ?? '—' }}</div>
                            <a href="{{ route('books.show', $book) }}" class="ml-4 px-3 py-1 bg-blue-600 text-black rounded">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-600">Belum ada buku yang cocok.</div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
