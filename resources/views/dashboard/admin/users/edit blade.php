@extends('layouts.admin')


@section('content')
    <a href="{{ route('dashboard.users.index') }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Manajemen Pengguna</a>

    <h1 class="text-3xl font-bold mb-6 text-center">Edit Pengguna: {{ $user->name }}</h1>

    <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Ada Kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Gunakan method PUT untuk update --}}

            <div class="mb-4 text-center">
                <label for="avatar" class="block text-gray-700 text-sm font-bold mb-2">Avatar:</label>
                @if($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="Avatar Saat Ini" class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-gray-300 mb-2">
                @else
                    <img src="{{ asset('images/default_avatar.png') }}" alt="Avatar Default" class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-gray-300 mb-2">
                @endif
                <input type="file" id="avatar" name="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mt-2">
                @error('avatar')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Kata Sandi Baru (kosongkan jika tidak ingin mengubah):</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Kata Sandi Baru:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="role_id" class="block text-gray-700 text-sm font-bold mb-2">Peran:</label>
                <select id="role_id" name="role_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role_id') border-red-500 @enderror" required>
                    <option value="">Pilih Peran</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="organization_id" class="block text-gray-700 text-sm font-bold mb-2">Organisasi (Opsional):</label>
                <select id="organization_id" name="organization_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('organization_id') border-red-500 @enderror">
                    <option value="">Pilih Organisasi</option>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}" {{ old('organization_id', $user->organization_id) == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </select>
                @error('organization_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="xp" class="block text-gray-700 text-sm font-bold mb-2">XP:</label>
                <input type="number" id="xp" name="xp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('xp') border-red-500 @enderror" value="{{ old('xp', $user->xp) }}">
                @error('xp')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </div>
@endsection