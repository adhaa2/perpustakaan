<x-guest-layout>
    <div class="min-h-full bg-blue-100 relative overflow-hidden">
        {{-- background bubbles --}}
        <!-- <div class="absolute -left-20 -top-20 w-72 h-72 bg-blue-200 rounded-full opacity-60 transform rotate-45"></div>
        <div class="absolute right-10 -top-10 w-40 h-40 bg-blue-200 rounded-full opacity-50"></div>
        <div class="absolute -right-24 bottom-10 w-64 h-64 bg-blue-200 rounded-full opacity-40"></div> -->

        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="max-w-md w-full">
                <div class="bg-white/90 backdrop-blur-sm shadow-lg rounded-xl p-8">




                    <h2 class="text-center text-xl font-semibold text-gray-800 mb-1">Buat akun baru</h2>
                    <p class="text-center text-sm text-gray-500 mb-6">Daftar untuk mulai meminjam & mengelola buku</p>

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-700 rounded">
                            <ul class="text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input id="name" name="name" type="text" required autofocus
                                value="{{ old('name') }}"
                                class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input id="email" name="email" type="email" required
                                value="{{ old('email') }}"
                                class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input id="password" name="password" type="password" required
                                class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                        </div>

                        {{-- Submit --}}
                        <div class="mb-4">
                            <button type="submit"
                                class="w-full px-4 py-2 rounded-md bg-primary text-white font-medium hover:bg-primary-dark transition">
                                Daftar
                            </button>
                        </div>

                        <div class="text-center text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Masuk</a>
                        </div>
                    </form>
                </div>

                {{-- small footer hint --}}
                <p class="text-center text-xs text-gray-400 mt-4">Dengan mendaftar, kamu menyetujui syarat & ketentuan.</p>
            </div>
        </div>
    </div>
</x-guest-layout>
