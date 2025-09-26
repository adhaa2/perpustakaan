<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      <!-- Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
          <div class="text-sm text-gray-500">Jumlah User</div>
          <div class="text-2xl font-bold mt-2">{{ $jumlahUsers }}</div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <div class="text-sm text-gray-500">Jumlah Buku</div>
          <div class="text-2xl font-bold mt-2">{{ $jumlahBuku }}</div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <div class="text-sm text-gray-500">Total Peminjaman</div>
          <div class="text-2xl font-bold mt-2">{{ $jumlahPeminjaman }}</div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <div class="text-sm text-gray-500">Peminjaman Aktif</div>
          <div class="text-2xl font-bold mt-2">{{ $peminjamanAktif }}</div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <div class="text-sm text-gray-500">Pending</div>
          <div class="text-2xl font-bold mt-2">{{ $peminjamanPending }}</div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <div class="text-sm text-gray-500">Overdue</div>
          <div class="text-2xl font-bold mt-2">{{ $overdue }}</div>
        </div>
      </div>

      <!-- Top Buku -->
      <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-3">Top 5 Buku</h3>
        <ul class="space-y-2">
          @forelse($topBuku as $b)
            <li class="flex justify-between">
              <div>{{ $b->judul }} <small class="text-gray-500">({{ $b->loans_count }} pinjam)</small></div>
            </li>
          @empty
            <li>Tidak ada data</li>
          @endforelse
        </ul>
      </div>

      <!-- Peminjaman Terakhir -->
      <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-3">Peminjaman Terakhir</h3>
        <table class="min-w-full text-sm">
          <thead class="text-left text-gray-500">
            <tr><th class="pb-2">User</th><th class="pb-2">Buku</th><th class="pb-2">Tanggal Pinjam</th><th class="pb-2">Status</th></tr>
          </thead>
          <tbody>
            @forelse($peminjamanTerakhir as $loan)
              <tr class="border-t">
                <td class="py-2">{{ $loan->user->name ?? '-' }}</td>
                <td class="py-2">{{ $loan->buku->judul ?? '-' }}</td>
                <td class="py-2">{{ optional($loan->tanggal_pinjam)->format('Y-m-d') ?? '-' }}</td>
                <td class="py-2"><span class="px-2 py-1 rounded {{ $loan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($loan->status === 'dipinjam' ? 'bg-green-100 text-green-800':'bg-gray-100')  }}">{{ ucfirst($loan->status) }}</span></td>
              </tr>
            @empty
              <tr><td colspan="4" class="py-4 text-center">Belum ada peminjaman</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>
