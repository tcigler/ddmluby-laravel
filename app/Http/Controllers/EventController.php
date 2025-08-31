<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller {
    use AuthorizesRequests;

    public function index() {
        $this->authorize('viewAny', Event::class);

        return inertia('Event/Index', ["events" => Event::all()]);
    }

    public function store(EventRequest $request) {
        $this->authorize('create', Event::class);

        return Event::create($request->validated());
    }

    public function show(Event $event) {
        $this->authorize('view', $event);

        return inertia('Event/Show', ["event" => $event, "hasTimeSlots" => $event->timeSlots()->exists()]);
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
