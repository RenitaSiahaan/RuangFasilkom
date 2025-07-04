<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        {{-- Logo atau Judul --}}
        <div class="text-xl font-bold text-primary-blue">
            Ruang Fasilkom
        </div>

        {{-- Menu Navigasi --}}
        <ul class="flex space-x-6 text-gray-700 font-medium">
            <li><a href="{{ route('home') }}" class="hover:text-blue-500">Home</a></li>
            <li><a href="{{ route('rooms.index') }}" class="hover:text-blue-500">Rooms</a></li>
            <li><a href="{{ route('history') }}" class="hover:text-blue-500">History</a></li>
            <li><a href="{{ route('profile') }}" class="hover:text-blue-500">Profile</a></li>
            @if(Auth::user() && Auth::user()->role_id === 1)
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-500">Dashboard</a></li>
            @endif
            <li>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-red-600">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
