<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Buku</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- flash -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <div class="text-lg font-medium">Daftar Buku</div>
                <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-blue-600 text-blue rounded">Tambah Buku</a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengarang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penerbit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($books as $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($books->currentPage()-1) * $books->perPage() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->judul }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->pengarang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->penerbit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->tahun_terbit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->stok }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">

                                    <a href="{{ route('admin.books.edit', $book) }}" class="inline-block px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                                    
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
