<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile | EventEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
    <nav class="bg-blue-900 text-white p-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">🎓 EventEase</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1 hover:underline text-white font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3-3m0 0l3 3m-3-3v12" />
                    </svg>
                    Back to Events
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-blue-200 hover:text-white text-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">My Registered Events</h2>
        @if(count($registeredEvents) === 0)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">You have not registered for any events yet.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($registeredEvents as $event)
                    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden flex flex-col h-full">
                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start">
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider bg-blue-50 px-2 py-1 rounded">
                                    {{ $event->category->name ?? 'General' }}
                                </span>
                                @if($event->status === 'closed')
                                    <span class="bg-gray-200 text-gray-600 text-xs font-bold px-2 py-1 rounded">CLOSED</span>
                                @endif
                            </div>
                            <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $event->title }}</h3>
                            <div class="mt-4 space-y-2 text-sm text-gray-600">
                                <p>📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y @ h:i A') }}</p>
                                <p>📍 {{ $event->venue->name ?? 'TBA' }}</p>
                                <p class="font-bold text-gray-800">💰 {{ $event->fee == 0 ? 'Free' : '$' . number_format($event->fee, 2) }}</p>
                                <form action="{{ route('event.unregister', $event->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to unregister from this event?');">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-100 text-red-700 py-2 rounded font-bold border border-red-200 hover:bg-red-200 transition">Unregister</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
