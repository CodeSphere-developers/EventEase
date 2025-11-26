<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard | EventEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
    
    <nav class="bg-blue-900 text-white p-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">🎓 EventEase</h1>
            <div class="flex items-center gap-4">
                <button id="studentProfileBtn" class="flex items-center gap-2 focus:outline-none">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                    <span class="flex flex-col items-start justify-center">
                        <span class="font-bold text-white leading-tight">{{ $user->name }}</span>
                        <span class="text-xs text-white bg-blue-700 rounded px-2 py-0.5 mt-0.5">Student</span>
                    </span>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-blue-200 hover:text-white text-sm">Logout</button>
                </form>
            </div>
        </div>
    <!-- Modal for Registered Events -->
    <div id="registeredEventsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <button id="closeRegisteredEventsModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-600 text-2xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold text-blue-900 mb-4">My Registered Events</h2>
            @if(isset($registeredEventIds) && count($registeredEventIds) === 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">You have not registered for any events yet.</div>
            @else
                <div class="space-y-3 max-h-72 overflow-y-auto">
                @foreach($events as $event)
                    @if(in_array($event->id, $registeredEventIds))
                        <div class="border rounded p-3 flex flex-col bg-blue-50">
                            <span class="font-bold text-blue-900">{{ $event->title }}</span>
                            <span class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y @ h:i A') }}</span>
                            <span class="text-xs text-gray-500">{{ $event->venue->name ?? 'TBA' }}</span>
                        </div>
                    @endif
                @endforeach
                </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('studentProfileBtn');
            const modal = document.getElementById('registeredEventsModal');
            const closeBtn = document.getElementById('closeRegisteredEventsModal');
            if(btn && modal && closeBtn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    modal.classList.remove('hidden');
                });
                closeBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });
                window.addEventListener('click', function(event) {
                    if(event.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    </nav>

    <div class="max-w-6xl mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Upcoming Events</h2>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden flex flex-col h-full">
                    
                    <!-- Event Header -->
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
                            
                            <!-- No Price, Just "School Sponsored" -->
                            <p class="font-bold text-green-600 text-sm mt-2">
                                ✅ School Sponsored (Free)
                            </p>
                            
                            <!-- Capacity -->
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

                    <!-- Action Footer -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <!-- Registration Status -->
                        @if(in_array($event->id, $registeredEventIds))
                            <div class="flex flex-col gap-2 mb-2">
                                <button disabled class="w-full bg-green-100 text-green-700 py-2 rounded font-bold border border-green-200">
                                    ✓ Registered
                                </button>
                                <form action="{{ route('event.unregister', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unregister from this event?');">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-100 text-red-700 py-2 rounded font-bold border border-red-200 hover:bg-red-200 transition">Unregister</button>
                                </form>
                            </div>
                        @elseif($event->status === 'open' && ($event->capacity === null || $event->registrations_count < $event->capacity))
                            <form action="{{ route('event.register', $event->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-bold transition">
                                    Register Now
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-100 text-gray-400 py-2 rounded font-bold cursor-not-allowed mb-2">
                                Unavailable
                            </button>
                        @endif

                        <!-- Feedback Section (only for registered students) -->
                        @php
                            $feedbacks = $event->feedbacks()->with('user')->orderBy('created_at', 'desc')->get();
                            $myFeedback = $event->feedbacks()->where('user_id', $user->id)->first();
                        @endphp
                        <div class="mt-2">
                            <h4 class="font-semibold text-sm text-gray-700 mb-1">Event Feedback</h4>
                            @if(in_array($event->id, $registeredEventIds))
                                <!-- Feedback Form -->
                                @if(!$myFeedback)
                                    <form action="{{ route('event.feedback', $event->id) }}" method="POST" class="mb-2">
                                        @csrf
                                        <textarea name="comment" rows="2" maxlength="1000" class="w-full border rounded p-2 text-sm mb-2" placeholder="Leave your feedback..." required></textarea>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold">Submit Feedback</button>
                                    </form>
                                @else
                                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs rounded p-2 mb-2">You submitted feedback: <span class="font-semibold">"{{ $myFeedback->comment }}"</span></div>
                                @endif
                            @endif
                            <!-- List of feedbacks (public) -->
                            @if($feedbacks->count())
                                <div class="bg-gray-100 rounded p-2 max-h-32 overflow-y-auto mt-2">
                                    @foreach($feedbacks as $fb)
                                        <div class="mb-1 text-xs text-gray-700 flex items-center justify-between">
                                            <span>
                                                <span class="font-bold">{{ $fb->user->name }}:</span> {{ $fb->comment }}
                                                <span class="text-gray-400 ml-2">({{ $fb->created_at->diffForHumans() }})</span>
                                            </span>
                                            @if(Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->id === $fb->user_id))
                                                @if(Auth::user()->role === 'admin')
                                                    <form action="{{ route('feedback.destroy', $fb->id) }}" method="POST" onsubmit="return confirm('Delete this feedback?');" class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">Delete</button>
                                                    </form>
                                                @elseif(Auth::user()->id === $fb->user_id)
                                                    <form action="{{ route('feedback.destroySelf', $fb->id) }}" method="POST" onsubmit="return confirm('Delete your feedback?');" class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">Delete</button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-xs text-gray-400 mt-2">No feedback yet.</div>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</body>
</html>