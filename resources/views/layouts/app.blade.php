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
                <button class="flex items-center gap-2 bg-blue-100 text-blue-700 rounded-full p-2 hover:bg-blue-200 transition-colors font-bold text-sm">
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1' /></svg>
                    Logout
                </button>
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
