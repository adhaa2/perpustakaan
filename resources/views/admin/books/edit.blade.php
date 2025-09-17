<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Buku</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form action="{{ route('admin.books.update', $book) }}" method="POST">
                    @method('PUT')
                    @include('admin.books._form')
                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-black rounded">Perbarui</button>
                        <a href="{{ route('admin.books.index') }}" class="ml-2 text-gray-600">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
