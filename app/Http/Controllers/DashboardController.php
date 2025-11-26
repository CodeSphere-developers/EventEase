<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Category;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Show edit form for an event (admin only)
    public function editEvent($id) {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        $event = Event::findOrFail($id);
        $venues = Venue::all();
        $categories = Category::all();
        return view('edit_event', compact('event', 'venues', 'categories'));
    }

    // Update event (admin only)
    public function updateEvent(Request $request, $id) {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        $event = Event::findOrFail($id);
        $venue = Venue::find($request->venue_id);
        $isSportsComplex = $venue && strtolower($venue->name) === 'sports complex';
        $rules = [
            'title' => 'required',
            'event_date' => 'required|date',
            'category_id' => 'required',
            'venue_id' => 'required',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:open,closed,pending',
            'announcement' => 'nullable|string|max:1000',
        ];
        if (!$isSportsComplex) {
            $rules['capacity'] = 'required|numeric';
        }
        $data = $request->validate($rules);
        if ($isSportsComplex) {
            $data['capacity'] = null;
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event_posters', 'public');
            $data['image'] = $path;
        }
        $event->update($data);
        return redirect()->route('dashboard')->with('success', 'Event updated successfully!');
    }
    public function index() {
        $user = Auth::user();
        $events = Event::with('venue', 'category')
            ->withCount('registrations')
            ->orderBy('event_date', 'asc')
            ->get();

        if ($user->role === 'admin') {
            return view('admin_dashboard', compact('events', 'user'));
        } elseif ($user->role === 'student') {
            $registeredEventIds = Registration::where('user_id', $user->id)
                ->pluck('event_id')
                ->toArray();
            return view('student_dashboard', compact('events', 'user', 'registeredEventIds'));
        } else {
            // fallback for other roles
            return view('dashboard', compact('events', 'user'));
        }
    }

    // --- ADMIN ACTIONS ---

    public function storeEvent(Request $request) {
        if(Auth::user()->role !== 'admin') abort(403);




        $venue = Venue::find($request->venue_id);
        $isSportsComplex = $venue && strtolower($venue->name) === 'sports complex';
        $rules = [
            'title' => 'required',
            'event_date' => 'required|date',
            'category_id' => 'required',
            'venue_id' => 'required',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:open,closed,pending',
            'announcement' => 'nullable|string|max:1000',
        ];
        if (!$isSportsComplex) {
            $rules['capacity'] = 'required|numeric';
        }
        $data = $request->validate($rules);
        if ($isSportsComplex) {
            $data['capacity'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event_posters', 'public');
            $data['image'] = $path;
        }


        // Force fee to 0 automatically
        $data['fee'] = 0;
        if (!isset($data['status'])) {
            $data['status'] = 'open';
        }

        Event::create($data);
        return back()->with('success', 'Event Created Successfully!');
    }

    public function destroyEvent($id) {
        if(Auth::user()->role !== 'admin') abort(403);
        Event::destroy($id);
        return back()->with('success', 'Event Deleted.');
    }

    public function toggleStatus($id) {
        if(Auth::user()->role !== 'admin') abort(403);
        $event = Event::findOrFail($id);
        $event->status = $event->status === 'open' ? 'closed' : 'open';
        $event->save();
        return back();
    }

    // --- STUDENT ACTIONS ---

    public function registerForEvent($id) {
        $event = Event::withCount('registrations')->findOrFail($id);
        // Prevent registration for closed events
        if($event->status === 'closed') {
            return back()->with('error', 'Cannot register for a closed event.');
        }
        $venue = $event->venue;
        $isSportsComplex = $venue && strtolower($venue->name) === 'sports complex';
        if (!$isSportsComplex && $event->capacity !== null && $event->registrations_count >= $event->capacity) {
            return back()->with('error', 'Cannot register.');
        }
        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $id
        ]);
    return back()->with('success', 'Registration Confirmed! (School Sponsored)');
    }

    // Student profile page: view registered events
    public function profile() {
        $user = Auth::user();
        // Only students can access their profile
        if ($user->role !== 'student') {
            abort(403);
        }
        $registeredEventIds = Registration::where('user_id', $user->id)
            ->pluck('event_id')->toArray();
        $registeredEvents = Event::with('venue', 'category')
            ->whereIn('id', $registeredEventIds)
            ->orderBy('start_time', 'asc')
            ->get();
        return view('profile', compact('user', 'registeredEvents'));
    }
    // Student can unregister from an event
    public function unregisterForEvent($id) {
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)->where('event_id', $id)->first();
        if ($registration) {
            // Delete feedback for this user/event
            \App\Models\Feedback::where('user_id', $user->id)->where('event_id', $id)->delete();
            $registration->delete();
            return back()->with('success', 'You have unregistered from the event and your feedback was removed.');
        }
        return back()->with('error', 'You are not registered for this event.');
    }
}