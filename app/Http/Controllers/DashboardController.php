<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        
        // Fetch events with the count of registrations
        $events = Event::with('venue', 'category')->withCount('registrations')->get();
        
        // Get list of event IDs the current user has registered for
        $myRegistrations = Registration::where('user_id', $user->id)
                            ->pluck('event_id')
                            ->toArray();

        return view('dashboard', compact('events', 'user', 'myRegistrations'));
    }

    public function registerForEvent($id) {
        $event = Event::withCount('registrations')->findOrFail($id);
        
        // Basic Check: Is full? Is closed?
        if($event->registrations_count >= $event->capacity || $event->status === 'closed') {
            return back()->with('error', 'Cannot register.');
        }

        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $id
        ]);

        return back()->with('success', 'You are registered!');
    }

    public function toggleStatus($id) {
        if(Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $event = Event::findOrFail($id);
        $event->status = $event->status === 'open' ? 'closed' : 'open';
        $event->save();

        return back();
    }
}
