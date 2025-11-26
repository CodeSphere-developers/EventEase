<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EventEase') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-100 via-white to-blue-100 min-h-screen font-sans">
    <!-- Header -->
    <header class="bg-red-900 shadow-lg">
        <div class="max-w-5xl mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎓</span>
                <span class="text-2xl font-extrabold text-white tracking-wide">EventEase</span>
            </div>
            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-white text-red-900 font-bold px-4 py-2 rounded shadow hover:bg-red-100 transition">Logout</button>
            </form>
            @endauth
        </div>
    </header>

    <!-- Main Content Card -->
    <main class="flex justify-center items-start py-10 px-2 min-h-[80vh]">
        <div class="w-full max-w-2xl bg-white/90 rounded-2xl shadow-2xl p-8 border border-red-200">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center text-xs text-gray-500 py-4">
        &copy; {{ date('Y') }} EventEase. All rights reserved.
    </footer>
</body>
</html>
