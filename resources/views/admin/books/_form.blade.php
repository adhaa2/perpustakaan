@csrf

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Judul</label>
        <input type="text" name="judul" value="{{ old('judul', $book->judul ?? '') }}"
            class="mt-1 block w-full border rounded p-2" required>
        @error('judul') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Pengarang</label>
        <input type="text" name="pengarang" value="{{ old('pengarang', $book->pengarang ?? '') }}"
            class="mt-1 block w-full border rounded p-2">
        @error('pengarang') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Penerbit</label>
        <input type="text" name="penerbit" value="{{ old('penerbit', $book->penerbit ?? '') }}"
            class="mt-1 block w-full border rounded p-2">
        @error('penerbit') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit ?? '') }}"
                class="mt-1 block w-full border rounded p-2" min="1000" max="{{ date('Y') }}">
            @error('tahun_terbit') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>


        <div>
            <label for="path_sampul">Link Sampul</label>
            <input type="text" name="path_sampul" value="{{ old('path_sampul', $book->path_sampul ?? '') }}"
                class="border rounded p-2 w-full" placeholder="https://example.com/gambar.jpg">

            @if(!empty($book->path_sampul))
                <div class="mt-2">
                    <img src="{{ $book->path_sampul }}" alt="Sampul {{ $book->judul }}" class="w-24">
                </div>
            @endif
        </div>



        <div>
            <label class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $book->stok ?? 1) }}"
                class="mt-1 block w-full border rounded p-2" min="0">
            @error('stok') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>