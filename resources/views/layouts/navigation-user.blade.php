<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- Left: logo -->
      <div class="flex items-center space-x-6">
        <a href="{{ route('dashboard') }}" class="text-lg font-bold text-primary">Perpustakaan</a>

        <!-- Desktop Links -->
        <div class="hidden sm:flex sm:items-center sm:space-x-4">
          <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-primary px-2 py-1 rounded {{ request()->routeIs('books.*') ? 'text-primary font-medium' : '' }}">Daftar Buku</a>
          <a href="{{ route('loans.index') }}" class="text-gray-700 hover:text-primary px-2 py-1 rounded {{ request()->routeIs('loans.*') ? 'text-primary font-medium' : '' }}">Peminjaman Saya</a>
        </div>
      </div>

      <!-- Right: auth links / profile -->
      <div class="flex items-center space-x-4">
        @auth
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-600 bg-white hover:text-gray-800">
                <span class="mr-2">{{ Auth::user()->name }}</span>
                <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
        @else
          <div class="hidden sm:flex sm:items-center sm:space-x-2">
            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary">Login</a>
            <a href="{{ route('register') }}" class="text-gray-700 hover:text-primary">Register</a>
          </div>

          <!-- mobile hamburger for guest -->
          <button @click="open = !open" class="sm:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        @endauth
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div x-show="open" x-cloak class="sm:hidden">
    <div class="pt-2 pb-3 space-y-1 px-2">
      @auth
        <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">Daftar Buku</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')">Peminjaman Saya</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Profile</x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}" class="px-2">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
        </form>
      @else
        <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">Login</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">Register</x-responsive-nav-link>
      @endauth
    </div>
  </div>
</nav>
