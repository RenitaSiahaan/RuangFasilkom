<x-guest-layout>
    <h1 class="text-2xl font-bold mb-2 text-center">Login</h1>
    <h5 class="text-lg font-semibold mb-4 text-center text-gray-700">Start Your Adventure Here</h5>

    {{-- Pesan dari reset password --}}
    @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- Pesan error login --}}
    @if(session()->has('loginError'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Login Gagal!</strong>
            <span class="block sm:inline">{{ session('loginError') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                   type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Kata Sandi</label>
            <input id="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                   type="password" name="password" required autocomplete="current-password">
            @error('password')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-center">
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Masuk
            </button>
        </div>

        <div class="mt-4 text-center">
            <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('password.request') }}">
                Lupa kata sandi? Klik di sini.
            </a>
        </div>
    </form>
</x-guest-layout>
