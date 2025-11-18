<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Juragan Empang</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <nav class="bg-gray-800 p-4 shadow-lg fixed w-full z-10 top-0">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white font-bold text-xl">☕ Juragan Empang</div>
            <div class="space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                <a href="{{ route('menus.index') }}" class="text-gray-300 hover:text-white">Menu Kopi</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-400 hover:text-red-200 ml-4">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-24 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>
