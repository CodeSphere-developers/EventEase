@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md border-t-4 border-red-600">
    <h2 class="text-2xl font-bold mb-6 text-red-800">Edit Event</h2>
    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="space-y-2 border-b pb-4">
            <label for="title" class="block text-sm font-bold mb-1 text-gray-700">Title</label>
            <input type="text" class="w-full border p-2 rounded focus:ring ring-red-200" id="title" name="title" value="{{ old('title', $event->title) }}" required>
        </div>
        <div class="space-y-2 border-b pb-4">
            <label for="event_date" class="block text-sm font-bold mb-1 text-gray-700">Event Date</label>
            <input type="date" class="w-full border p-2 rounded focus:ring ring-red-200" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date) }}" required>
        </div>
        <div class="space-y-2 border-b pb-4">
            <label for="category_id" class="block text-sm font-bold mb-1 text-gray-700">Category</label>
            <select class="w-full border p-2 rounded bg-white" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2 border-b pb-4">
            <label for="venue_id" class="block text-sm font-bold mb-1 text-gray-700">Venue</label>
            <select class="w-full border p-2 rounded bg-white" id="venue_id" name="venue_id" required>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}" {{ $event->venue_id == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2 border-b pb-4">
            <label for="capacity" class="block text-sm font-bold mb-1 text-gray-700">Capacity</label>
            <input type="number" class="w-full border p-2 rounded focus:ring ring-red-200" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}" required>
        </div>
        <div class="space-y-2 border-b pb-4">
            <label for="status" class="block text-sm font-bold mb-1 text-gray-700">Status</label>
            <select class="w-full border p-2 rounded bg-white" id="status" name="status" required>
                <option value="open" {{ $event->status == 'open' ? 'selected' : '' }}>Open</option>
                <option value="pending" {{ $event->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="closed" {{ $event->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <div class="space-y-2 border-b pb-4">
            <label for="announcement" class="block text-sm font-bold mb-1 text-gray-700">Event Announcement (optional)</label>
            <textarea class="w-full border rounded p-2 text-sm" id="announcement" name="announcement" rows="3" maxlength="1000" placeholder="Add an announcement or important info for this event...">{{ old('announcement', $event->announcement) }}</textarea>
        </div>
        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded font-bold shadow hover:bg-red-700 transition-colors">Update Event</button>
            <a href="{{ route('dashboard') }}" class="flex-1 text-center bg-gray-300 text-gray-800 py-2 rounded font-bold shadow hover:bg-gray-400 transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
