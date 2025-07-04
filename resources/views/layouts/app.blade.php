<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ruang Fasilkom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tambahkan Tailwind atau CSS yang kamu pakai --}}
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js', 'resource/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    {{-- Navbar --}}
    <nav class="bg-white shadow px-4 py-3 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-lg font-bold text-blue-600">Ruang Fasilkom</a>
        <div class="space-x-4">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
            <a href="{{ route('rooms.index') }}" class="text-gray-700 hover:text-blue-600">Rooms</a>
            <a href="{{ route('history.index') }}" class="text-gray-700 hover:text-blue-600">History</a>
            <a href="{{ route('user.profile') }}" class="text-gray-700 hover:text-blue-600">Profile</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-600">Logout</button>
            </form>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="flex-1 py-6 px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white text-center py-4 shadow-inner text-sm text-gray-500">
        &copy; {{ date('Y') }} Ruang Fasilkom
    </footer>
</body>
</html>
