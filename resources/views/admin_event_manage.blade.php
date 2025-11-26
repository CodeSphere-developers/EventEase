@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md border-t-4 border-red-600">
    <h2 class="text-2xl font-bold mb-6 text-red-800">Manage Events</h2>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="p-4">Title</th>
                    <th class="p-4">Date / Venue</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($events as $event)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-bold">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Poster" class="w-24 h-24 object-cover rounded mb-2 border">
                        @endif
                        {{ $event->title }}
                        <div class="text-xs text-blue-600 font-normal">{{ $event->category->name ?? 'None' }}</div>
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y H:i') }}<br>
                        {{ $event->venue->name ?? 'TBA' }}
                    </td>
                    <td class="p-4">
                        @php
                            $now = \Carbon\Carbon::now();
                            $eventDate = isset($event->event_date) ? \Carbon\Carbon::parse($event->event_date) : null;
                            $isClosed = $eventDate && $eventDate->isPast();
                            $status = $isClosed ? 'closed' : $event->status;
                        @endphp
                        <form action="{{ route('event.toggle', $event->id) }}" method="POST">
                            @csrf
                            <button class="text-xs font-bold px-2 py-1 rounded {{ $status == 'open' ? 'bg-green-100 text-green-800' : ($status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ strtoupper($status) }}
                            </button>
                        </form>
                    </td>
                    <td class="p-4 text-right flex justify-end gap-2">
                        <a href="{{ route('events.edit', $event->id) }}" class="text-blue-500 hover:text-blue-700 font-bold text-sm mr-2">Edit</a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 font-bold text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex gap-3 mt-4">
    <a href="{{ route('dashboard') }}" class="bg-gray-300 text-gray-800 py-2 px-4 rounded font-bold shadow hover:bg-gray-400 transition-colors">Back to Home</a>
    </div>
</div>
@endsection
