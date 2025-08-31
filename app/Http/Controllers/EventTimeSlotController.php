<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTimeSlotRequest;
use App\Models\EventTimeSlot;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventTimeSlotController extends Controller {
    use AuthorizesRequests;

    public function index() {
        $this->authorize('viewAny', EventTimeSlot::class);

        return EventTimeSlot::all();
    }

    public function store(EventTimeSlotRequest $request) {
        $this->authorize('create', EventTimeSlot::class);

        return EventTimeSlot::create($request->validated());
    }

    public function show(EventTimeSlot $eventTimeSlot) {
        $this->authorize('view', $eventTimeSlot);

        return $eventTimeSlot;
    }

    public function update(EventTimeSlotRequest $request, EventTimeSlot $eventTimeSlot) {
        $this->authorize('update', $eventTimeSlot);

        $eventTimeSlot->update($request->validated());

        return $eventTimeSlot;
    }

    public function destroy(EventTimeSlot $eventTimeSlot) {
        $this->authorize('delete', $eventTimeSlot);

        $eventTimeSlot->delete();

        return response()->json();
    }
}
