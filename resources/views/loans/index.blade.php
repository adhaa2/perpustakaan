<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Peminjaman</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($loans as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($loans->currentPage()-1) * $loans->perPage() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $loan->buku->judul ?? '—' }}<br>
                                    <small class="text-gray-500">{{ $loan->buku->pengarang ?? '' }}</small>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ optional($loan->tanggal_pinjam)->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ optional($loan->tanggal_jatuh_tempo)->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $loan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $loan->status === 'dipinjam' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $loan->status === 'ditolak' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $loan->status === 'dikembalikan' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">Belum ada riwayat peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
