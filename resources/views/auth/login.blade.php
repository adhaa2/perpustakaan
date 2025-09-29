<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

<div class="max-w-md w-full bg-white/90 backdrop-blur-sm shadow-lg rounded-xl p-8 relative z-10">
    <h2 class="text-center text-xl font-semibold text-gray-800 mb-1">Welcome Back</h2>
    <p class="text-center text-sm text-gray-500 mb-6">Masuk untuk mulai meminjam & mengelola buku</p>
    
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
  <x-text-input id="email" 
              type="email" 
              name="email" 
              :value="old('email')" 
              required autofocus autocomplete="username"
              class="block mt-1 w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-1">
            <!-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif -->

            <x-primary-button class=" px-4 py-2 rounded-md bg-primary text-white font-medium hover:bg-primary-dark transition">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
                        <div class="text-center text-sm text-gray-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Daftar</a>
                        </div>
                    </form>
                </div>
    </form>
    </div>
</x-guest-layout>
