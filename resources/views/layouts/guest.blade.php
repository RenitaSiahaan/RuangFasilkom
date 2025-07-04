<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: url('/images/1.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .auth-card {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

    .logo-img {
        max-width: 40%;  
        width: 50%;    
        height: auto;     
        object-fit: contain; 
        display: block;
        margin: 0 auto;
    }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <img src="{{ asset('images/2.png') }}" alt="Logo" class="logo-img">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
