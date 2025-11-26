@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md border-t-4 border-blue-600">
    <h2 class="text-2xl font-bold mb-6 text-blue-800">Manage Feedback</h2>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="p-4">Event</th>
                    <th class="p-4">User</th>
                    <th class="p-4">Comment</th>
                    <th class="p-4">Date</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($feedbacks as $fb)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-bold">{{ $fb->event->title ?? 'N/A' }}</td>
                    <td class="p-4">{{ $fb->user->name ?? 'N/A' }}</td>
                    <td class="p-4">{{ $fb->comment }}</td>
                    <td class="p-4 text-xs text-gray-500">{{ $fb->created_at->format('M d, Y H:i') }}</td>
                    <td class="p-4 text-right">
                        <form action="{{ route('feedback.destroy', $fb->id) }}" method="POST" onsubmit="return confirm('Delete this feedback?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('dashboard') }}" class="inline-block mt-4 bg-gray-300 text-gray-800 py-2 px-4 rounded font-bold shadow hover:bg-gray-400 transition-colors">Back to Home</a>
</div>
@endsection