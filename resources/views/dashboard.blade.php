<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Events Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        @if($user->role === 'admin')
        <!-- Sidebar for Admin -->
        <aside class="w-64 bg-red-900 text-white flex flex-col py-8 px-4 shadow-lg">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-full bg-red-200 flex items-center justify-center shadow-inner">
                    <span class="text-2xl font-bold text-red-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <div class="flex flex-col items-start">
                    <span class="text-base font-bold text-white">{{ $user->name }}</span>
                    <span class="text-xs text-red-100 font-semibold mt-1 px-2 py-0.5 rounded bg-red-700/60">Admin</span>
                </div>
            </div>
            <nav class="flex flex-col gap-2 mt-4">
                <a href="{{ route('dashboard') }}" class="py-2 px-4 rounded font-bold hover:bg-red-800 transition-colors {{ request()->routeIs('dashboard') ? 'bg-red-800' : '' }}">🏠 Home</a>
                <a href="{{ route('events.create') }}" class="py-2 px-4 rounded font-bold hover:bg-red-800 transition-colors {{ request()->routeIs('events.create') ? 'bg-red-800' : '' }}">➕ Create New Event</a>
                <a href="{{ route('events.manage') }}" class="py-2 px-4 rounded font-bold hover:bg-red-800 transition-colors {{ request()->routeIs('events.manage') ? 'bg-red-800' : '' }}">🗂️ Manage Events</a>
                <a href="{{ route('feedback.manage') }}" class="py-2 px-4 rounded font-bold hover:bg-red-800 transition-colors {{ request()->routeIs('feedback.manage') ? 'bg-red-800' : '' }}">💬 Manage Feedback</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-8">
                    @csrf
                    <button class="w-full bg-white/10 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors">Logout</button>
                </form>
            </nav>
        </aside>
        @endif
        <div class="flex-1">
            <!-- Main Content -->

    <main class="max-w-6xl mx-auto p-6">
        <!-- Admin Buttons removed: now handled by sidebar navigation -->
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Upcoming Events</h2>
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
                    @if($event->image)
                        <div class="w-full h-40 bg-gray-100 overflow-hidden flex items-center justify-center">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Banner" class="object-cover w-full h-full">
                        </div>
                    @endif
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
                                💰 Free Entry
                            </p>
                            
                            <div class="pt-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Capacity</span>
                                    <span>
                                        @if($event->capacity === null)
                                            Unlimited
                                        @else
                                            {{ $event->registrations_count }} / {{ $event->capacity }}
                                        @endif
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $percent = 0;
                                        if ($event->capacity && $event->capacity > 0) {
                                            $percent = ($event->registrations_count / $event->capacity) * 100;
                                            $percent = $percent > 100 ? 100 : $percent;
                                        } elseif ($event->capacity === null) {
                                            $percent = 0;
                                        }
                                    @endphp
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $event->capacity ? $percent : 0 }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            @if($event->announcement)
                                <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">
                                    <div class="font-bold text-yellow-800 text-sm flex items-center gap-2 mb-1">
                                        <span>📢 Admin Announcement</span>
                                    </div>
                                    <div class="text-yellow-900 text-sm">{!! nl2br(e($event->announcement)) !!}</div>
                                </div>
                            @endif
                            @if($user->role === 'student')
                                @if(in_array($event->id, $registeredEventIds))
                                    <div class="flex flex-col gap-2">
                                        <button disabled class="w-full bg-blue-50 text-blue-700 py-2 rounded font-semibold border border-blue-200">✓ Registered</button>
                                        <form action="{{ route('event.unregister', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unregister from this event?');">
                                            @csrf
                                            <button type="submit" class="w-full bg-red-100 text-red-700 py-2 rounded font-bold border border-red-200 hover:bg-red-200 transition">Unregister</button>
                                        </form>
                                    </div>
                                @elseif($event->status === 'closed')
                                    <button disabled class="w-full bg-gray-100 text-gray-400 py-2 rounded font-semibold cursor-not-allowed">Registration Closed</button>
                                @elseif($event->capacity !== null && $event->registrations_count >= $event->capacity)
                                    <button disabled class="w-full bg-red-50 text-red-400 py-2 rounded font-semibold cursor-not-allowed">Event Full</button>
                                @else
                                    <form action="{{ route('event.register', $event->id) }}" method="POST">
                                        @csrf
                                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold transition">Register Now</button>
                                    </form>
                                @endif

                                <!-- Feedback Section for Students -->
                                @php
                                    $feedbacks = $event->feedbacks()->with('user')->orderBy('created_at', 'desc')->get();
                                    $myFeedback = $event->feedbacks()->where('user_id', $user->id)->first();
                                @endphp
                                <div class="mt-4">
                                    <h4 class="font-semibold text-sm text-gray-700 mb-1">Event Feedback</h4>
                                    @if(in_array($event->id, $registeredEventIds))
                                        @if(!$myFeedback)
                                            <form action="{{ route('event.feedback', $event->id) }}" method="POST" class="mb-2">
                                                @csrf
                                                <textarea name="comment" rows="2" maxlength="1000" class="w-full border rounded p-2 text-sm mb-2" placeholder="Leave your feedback..." required></textarea>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold">Submit Feedback</button>
                                            </form>
                                        @else
                                            <div class="bg-green-50 border border-green-200 text-green-800 text-xs rounded p-2 mb-2 flex items-center justify-between">
                                                <span>You submitted feedback: <span class="font-semibold">\"{{ $myFeedback->comment }}\"</span></span>
                                                <form action="{{ route('feedback.destroySelf', $myFeedback->id) }}" method="POST" onsubmit="return confirm('Delete your feedback?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ml-2 text-red-600 hover:underline text-xs">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mb-2 text-xs text-gray-500">Register for this event to leave feedback.</div>
                                    @endif
                                    <div class="mt-2">
                                        <h5 class="font-semibold text-xs text-gray-600 mb-1">All Feedback for this Event</h5>
                                        @if($feedbacks->count())
                                            <div class="bg-gray-100 rounded p-2 max-h-32 overflow-y-auto">
                                                @foreach($feedbacks as $fb)
                                                    <div class="mb-1 text-xs text-gray-700 flex items-center justify-between">
                                                        <span><span class="font-bold">{{ $fb->user->name }}:</span> {{ $fb->comment }}
                                                        <span class="text-gray-400 ml-2">({{ $fb->created_at->diffForHumans() }})</span></span>
                                                        @if($fb->user_id === $user->id)
                                                            <form action="{{ route('feedback.destroySelf', $fb->id) }}" method="POST" onsubmit="return confirm('Delete your feedback?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="ml-2 text-red-600 hover:underline text-xs">Delete</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-400">No feedback yet.</div>
                                        @endif
                                    </div>
                                </div>
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