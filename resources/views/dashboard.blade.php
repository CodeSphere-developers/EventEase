<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Events Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-blue-900 text-white p-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wide">🎓 CampusEvents</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm bg-blue-800 px-3 py-1 rounded-full">
                    {{ $user->name }} ({{ ucfirst($user->role) }})
                </span>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="hover:underline text-sm text-red-200">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Upcoming Events</h2>
            @if($user->role === 'admin')
                <button class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">
                    + Create New Event
                </button>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden relative group">
                    
                    <div class="absolute top-4 right-4">
                        @if($event->status === 'open')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">OPEN</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded-full">CLOSED</span>
                        @endif
                    </div>

                    <div class="p-6">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">
                            {{ $event->category->name ?? 'General' }}
                        </span>
                        
                        <h3 class="mt-2 text-xl font-bold text-gray-900">{{ $event->title }}</h3>
                        
                        <div class="mt-4 space-y-2 text-sm text-gray-600">
                            <p class="flex items-center gap-2">
                                📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y @ h:i A') }}
                            </p>
                            <p class="flex items-center gap-2">
                                📍 {{ $event->venue->name ?? 'TBA' }}
                            </p>
                            <p class="flex items-center gap-2">
                                💰 {{ $event->fee == 0 ? 'Free Entry' : '$' . number_format($event->fee, 2) }}
                            </p>
                            
                            <div class="pt-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Capacity</span>
                                    <span>{{ $event->registrations_count }} / {{ $event->capacity }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" 
                                         style="width: {{ min(($event->registrations_count / $event->capacity) * 100, 100) }}%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            @if($user->role === 'student')
                                @if(in_array($event->id, $myRegistrations))
                                    <button disabled class="w-full bg-blue-50 text-blue-700 py-2 rounded font-semibold border border-blue-200">
                                        ✓ Registered
                                    </button>
                                @elseif($event->status === 'closed')
                                    <button disabled class="w-full bg-gray-100 text-gray-400 py-2 rounded font-semibold cursor-not-allowed">
                                        Registration Closed
                                    </button>
                                @elseif($event->registrations_count >= $event->capacity)
                                    <button disabled class="w-full bg-red-50 text-red-400 py-2 rounded font-semibold cursor-not-allowed">
                                        Event Full
                                    </button>
                                @else
                                    <form action="{{ route('event.register', $event->id) }}" method="POST">
                                        @csrf
                                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold transition">
                                            Register Now
                                        </button>
                                    </form>
                                @endif

                            @elseif($user->role === 'admin')
                                <form action="{{ route('event.toggle', $event->id) }}" method="POST">
                                    @csrf
                                    <button class="w-full py-2 rounded font-semibold border transition
                                        {{ $event->status === 'open' ? 'border-red-500 text-red-500 hover:bg-red-50' : 'border-green-500 text-green-500 hover:bg-green-50' }}">
                                        {{ $event->status === 'open' ? 'Close Event' : 'Open Event' }}
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </main>

</body>
</html>