<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Manajemen Peminjaman</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- search -->
             <form action="{{ route('admin.loans.index') }}" method="GET" class="mb-4">
    <div class="flex gap-2">
        <input type="text" name="q" value="{{ $q ?? '' }}"
               placeholder="Cari nama peminjam atau judul buku..."
               class="w-full border rounded p-2">

        {{-- Pertahankan filter status saat search jika ada --}}
        @if(!empty($status))
            <input type="hidden" name="status" value="{{ $status }}">
        @endif

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Cari</button>

        @if(!empty($q))
            {{-- Reset: tetap pertahankan status jika ada --}}
            <a href="{{ route('admin.loans.index', $status ? ['status' => $status] : []) }}"
               class="px-4 py-2 bg-gray-200 rounded">Reset</a>
        @endif
    </div>
</form>

            @if(session('success')) <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div> @endif

            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Buku</th>
                            <th class="px-4 py-2">Tanggal Pinjam</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $loop->iteration + ($loans->currentPage()-1) * $loans->perPage() }}</td>
                            <td class="px-4 py-2">{{ $loan->user->name }}<br><small>{{ $loan->user->email }}</small></td>
                            <td class="px-4 py-2">{{ $loan->buku->judul ?? '—' }}</td>
                            <td class="px-4 py-2">{{ optional($loan->tanggal_pinjam)->format('Y-m-d') ?? '-' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($loan->status) }}</td>
                            <td class="px-4 py-2 text-right space-x-2">
                                @if($loan->status === 'pending')
                                    <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        <button onclick="return confirm('Setujui permintaan ini?')" class="px-3 py-1 bg-green-600 text-black rounded">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.loans.reject', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        <button onclick="return confirm('Tolak permintaan ini?')" class="px-3 py-1 bg-red-600 text-black rounded">Tolak</button>
                                    </form>
                                @elseif($loan->status === 'dipinjam')
                                    <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        <button onclick="return confirm('Tandai sudah dikembalikan?')" class="px-3 py-1 bg-blue-600 text-black rounded">Return</button>
                                    </form>
                                @else
                                    <span class="text-sm text-gray-600">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center">Belum ada data</td>
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
