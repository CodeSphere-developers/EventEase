@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md border-t-4 border-green-600">
    <h2 class="text-2xl font-bold mb-6 text-green-800">Publish New Event</h2>
    <form action="{{ route('events.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="block text-sm font-bold mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded bg-white">
                <option value="open">Open</option>
                <option value="pending">Pending</option>
                <option value="closed">Closed</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Event Poster (Image)</label>
            <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded bg-white">
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Event Title</label>
            <input type="text" name="title" required class="w-full border p-2 rounded focus:ring ring-red-200">
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Event Date & Time</label>
            <input type="datetime-local" name="event_date" required class="w-full border p-2 rounded">
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="block text-sm font-bold mb-1">Category</label>
                <select name="category_id" class="w-full border p-2 rounded bg-white">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Venue</label>
                <select name="venue_id" class="w-full border p-2 rounded bg-white">
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}">{{ $venue->name }} ({{ $venue->capacity }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Max Capacity</label>
            <input type="number" name="capacity" required class="w-full border p-2 rounded" value="100">
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Event Announcement (optional)</label>
            <textarea name="announcement" rows="3" maxlength="1000" class="w-full border rounded p-2 text-sm" placeholder="Add an announcement or important info for this event..."></textarea>
        </div>
        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">+ Publish Event</button>
    </form>
    <a href="{{ route('dashboard') }}" class="inline-block mt-4 bg-gray-300 text-gray-800 py-2 px-4 rounded font-bold shadow hover:bg-gray-400 transition-colors">Back to Home</a>
</div>
@endsection
