<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | EventEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav class="bg-red-900 text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">🎓 EventEase <span class="text-red-300 text-sm">ADMIN PANEL</span></h1>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-600 text-white font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
                <div class="flex flex-col items-start justify-center">
                    <span class="font-bold text-white leading-tight">{{ $user->name }}</span>
                    <span class="text-xs text-white bg-red-700 rounded px-2 py-0.5 mt-0.5">Admin</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="ml-2">
                    @csrf
                    <button class="bg-red-800 hover:bg-red-700 px-4 py-2 rounded text-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- SIDEBAR PANEL -->
        <aside class="w-64 bg-white p-0 shadow-md border-t-4 border-red-600 flex flex-col items-stretch min-h-screen">
            <div class="flex flex-col divide-y divide-gray-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-5 hover:bg-gray-50 transition-colors">
                    <span class="bg-gray-100 text-gray-700 rounded-full p-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12h18M3 6h18M3 18h18'/></svg></span>
                    <span class="font-bold text-gray-700">Home</span>
                </a>
                <a href="{{ route('events.create') }}" class="flex items-center gap-3 px-6 py-5 hover:bg-green-50 transition-colors">
                    <span class="bg-green-100 text-green-700 rounded-full p-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4v16m8-8H4'/></svg></span>
                    <span class="font-bold text-green-700">Create New Event</span>
                </a>
                <a href="{{ route('events.manage') }}" class="flex items-center gap-3 px-6 py-5 hover:bg-red-50 transition-colors">
                    <span class="bg-red-100 text-red-700 rounded-full p-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6'/></svg></span>
                    <span class="font-bold text-red-700">Manage Events</span>
                </a>
                <a href="{{ route('feedback.manage') }}" class="flex items-center gap-3 px-6 py-5 hover:bg-blue-50 transition-colors">
                    <span class="bg-blue-100 text-blue-700 rounded-full p-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2m2-4h4a2 2 0 012 2v4a2 2 0 01-2 2h-4a2 2 0 01-2-2V6a2 2 0 012-2z'/></svg></span>
                    <span class="font-bold text-blue-700">Manage Feedback</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT: Manage Events -->
        <main class="flex-1 p-8 space-y-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Upcoming Events</h2>
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden flex flex-col h-full">
                        <div class="p-6 flex-grow">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Poster" class="w-full h-40 object-cover rounded mb-3 border">
                            @endif
                            <div class="flex justify-between items-start">
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider bg-blue-50 px-2 py-1 rounded">
                                    {{ $event->category->name ?? 'General' }}
                                </span>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-200 text-yellow-800',
                                        'open' => 'bg-green-200 text-green-800',
                                        'closed' => 'bg-gray-200 text-gray-600',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'PENDING',
                                        'open' => 'OPEN',
                                        'closed' => 'CLOSED',
                                    ];
                                    $status = $event->status;
                                @endphp
                                <span class="{{ $statusColors[$status] ?? 'bg-gray-200 text-gray-600' }} text-xs font-bold px-2 py-1 rounded">
                                    {{ $statusLabels[$status] ?? strtoupper($status) }}
                                </span>
                            </div>
                            <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $event->title }}</h3>
                            <div class="mt-4 space-y-2 text-sm text-gray-600">
                                <p>📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y @ h:i A') }}</p>
                                <p>📍 {{ $event->venue->name ?? 'TBA' }}</p>
                                <p class="font-bold text-green-600 text-sm mt-2">✅ School Sponsored (Free)</p>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $event->capacity ? min(($event->registrations_count / $event->capacity) * 100, 100) : 0 }}%"></div>
                                </div>
                                <div class="text-xs text-right text-gray-400">
                                    @if($event->capacity === null)
                                        Unlimited
                                    @else
                                        {{ $event->registrations_count }} / {{ $event->capacity }} filled
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                            <form action="{{ route('event.toggle', $event->id) }}" method="POST">
                                @csrf
                                <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded font-bold transition">Close Event</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>