<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class BookingController extends Controller {
    public function eventsIndex() {
//        $this->authorize('viewAny', Event::class);

        $events = Event::all();

        return inertia('Admin/Event/Index', ["events" => $events]);
    }

    public function eventShow(Event $event) {
//        $this->authorize('viewAny', Event::class);

        return inertia('Admin/Event/Show', [
            "event" => $event,
            "bookings" => $event->eventBookings()
                ->with('userInfo')->with('attendees')->with('eventTimeSlot')
                ->orderBy("event_time_slots.time")->get()
        ]);
    }

    public function index() {

    }
}
