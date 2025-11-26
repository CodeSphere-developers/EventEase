<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Store feedback for an event
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        // Only allow feedback if user is registered for the event
        $isRegistered = $event->registrations()->where('user_id', $user->id)->exists();
        if (!$isRegistered) {
            return back()->with('error', 'You must be registered for this event to leave feedback.');
        }

        // Only one feedback per user per event
        $existing = Feedback::where('event_id', $eventId)->where('user_id', $user->id)->first();
        if ($existing) {
            return back()->with('error', 'You have already submitted feedback for this event.');
        }

        Feedback::create([
            'event_id' => $eventId,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }

    // Admin: Manage all feedbacks
    public function manage()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        $feedbacks = \App\Models\Feedback::with('user', 'event')->orderBy('created_at', 'desc')->get();
        return view('admin_feedback_manage', compact('feedbacks'));
    }

    // Admin: Delete feedback
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback deleted.');
    }
    // Student: Delete own feedback
    public function destroySelf($id)
    {
        $user = Auth::user();
        $feedback = Feedback::findOrFail($id);
        if ($feedback->user_id !== $user->id) {
            abort(403);
        }
        $feedback->delete();
        return back()->with('success', 'Your feedback was deleted.');
    }
}
