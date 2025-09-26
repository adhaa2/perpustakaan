<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Buku</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- search -->
            <form action="{{ route('admin.books.index') }}" method="GET" class="mb-6">
                <div class="flex gap-2">
                    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari judul, pengarang, penerbit..."
                        class="w-full border rounded p-2">

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>

                    @if(!empty($q))
                        <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-gray-200 rounded">Reset</a>
                    @endif
                </div>
            </form>

            <!-- flash -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="mb-4 flex justify-end items-center">
                <!-- <div class="text-lg font-medium">Daftar Buku</div> -->
                <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded"> + Tambah
                    Buku</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Pengarang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Penerbit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($books as $book)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold">{{ $book->judul }}</td>
                                <td class="px-6 py-4">{{ $book->pengarang }}</td>
                                <td class="px-6 py-4">{{ $book->penerbit }}</td>
                                <td class="px-6 py-4">{{ $book->tahun_terbit }}</td>
                                <td class="px-6 py-4">{{ $book->stok }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    <div class="p-4">
                        {{ $books->links() }}
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>