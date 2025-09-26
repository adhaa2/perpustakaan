<nav x-data="{ open: false }" class="z-40">
  <!-- Desktop sidebar -->
  <aside class="hidden md:block fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200">
    <div class="h-full flex flex-col">
      <div class="px-4 py-6">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-primary">Perpustakaan</a>
      </div>

      <div class="flex-1 px-2 space-y-1">
        <a href="{{ route('admin.dashboard') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
           Dashboard
        </a>

        <a href="{{ route('admin.books.index') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.books.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
           Kelola Buku
        </a>

        <a href="{{ route('admin.loans.index') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.loans.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
           Kelola Peminjaman
        </a>

      </div>

      <div class="px-4 py-4 border-t border-gray-100">
        <!-- profile small -->
        @auth
          <div class="text-sm text-gray-700">{{ Auth::user()->name }}</div>
          <div class="mt-2">
            <x-dropdown align="right" width="48">
              <x-slot name="trigger">
                <button class="w-full inline-flex justify-between items-center px-3 py-2 bg-white border rounded text-sm">
                  Akun
                  <svg class="h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
              </x-slot>

              <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                </form>
              </x-slot>
            </x-dropdown>
          </div>
        @endauth
      </div>
    </div>
  </aside>

  <!-- Mobile top bar with hamburger to open drawer -->
  <div class="md:hidden bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
    <div class="flex items-center space-x-3">
      <button @click="open = true" class="p-2 rounded-md text-gray-600 hover:bg-gray-100">
        <!-- hamburger -->
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
      <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-primary">Perpustakaan</a>
    </div>

    <div>
      @auth
        <x-dropdown align="right">
          <x-slot name="trigger">
            <button class="inline-flex items-center px-2 py-1 rounded bg-white border text-sm">
              {{ Auth::user()->name }}
            </button>
          </x-slot>
          <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}"> @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-sm">Log Out</button>
            </form>
          </x-slot>
        </x-dropdown>
      @endauth
    </div>
  </div>

  <!-- Mobile drawer -->
  <div x-show="open" x-cloak class="md:hidden fixed inset-0 z-50">
    <div @click="open = false" class="absolute inset-0 bg-black/40"></div>
    <aside class="relative w-64 bg-white h-full shadow-lg">
      <div class="p-4">
        <div class="flex items-center justify-between">
          <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-primary">Perpustakaan</a>
          <button @click="open = false" class="p-1 rounded-md text-gray-600 hover:bg-gray-100">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <nav class="mt-6 space-y-1">
          <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">Dashboard</a>
          <a href="{{ route('admin.books.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.books.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">Kelola Buku</a>
          <a href="{{ route('admin.loans.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.loans.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">Kelola Peminjaman</a>
        
        </nav>
      </div>
    </aside>
  </div>
</nav>
