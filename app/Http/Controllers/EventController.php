<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EventController extends Controller {
    use AuthorizesRequests;

    public function index() {
        $this->authorize('viewAny', Event::class);

        $events = Event::where("show_from", "<", Carbon::now())->get();

        return inertia('Event/Index', ["events" => $events]);
    }

    public function store(EventRequest $request) {
        $this->authorize('create', Event::class);

        return Event::create($request->validated());
    }

    public function show(Request $request) {
        $identifier = $request->event;
        if (is_numeric($identifier)) {
            $event = Event::findOrFail($identifier);
        } else {
            $event = Event::findBySlugOrFail($identifier);
        }
        $this->authorize('view', $event);
        return inertia('Event/Show', [
            "event" => $event,
            "can_register" => ($event->timeSlots()->exists() && isset($event->registration_from)),
            "registration_later" => (isset($event->registration_from) && Carbon::now()->isBefore($event->registration_from)) ? $event->registration_from : null,
        ]);
    }

    public function update(EventRequest $request, Event $event) {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return $event;
    }

    public function destroy(Event $event) {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json();
    }
}
