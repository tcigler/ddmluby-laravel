<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventBookingRequest;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\EventBooking;
use App\Models\EventTimeSlot;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class EventBookingController extends Controller {
    use AuthorizesRequests;

    public function index() {
        $this->authorize('viewAny', EventBooking::class);

        return EventBooking::all();
    }

    public function create(Event $event) {
        $this->authorize('create', EventBooking::class);

        return inertia("EventBooking/Create", [
            "event" => $event,
            "timeSlots" => $event->timeSlots()->orderBy('time')->withRemaining()->get()
        ]);
    }

    public function store(Event $event, Request $request) {
        $this->authorize('create', EventBooking::class);

        $attendeesRules = [
            'attendeesCount' => ['required', 'integer', 'min:1', "max:6"], // FIXME: max count configurable or constant
            'attendeeNote' => ['required', 'array', 'min:1'],
            'attendeeNote.*' => ['required', 'string', 'max:255', 'min:1'],
        ];

        $attendees = $request->validate($attendeesRules);

        $attendeesRegCount = $attendees["attendeesCount"];
        if ($attendeesRegCount != count($attendees["attendeeNote"])) {
            throw ValidationException::withMessages([
                'attendeeNote' => ['The count field must match the number of items.'],
            ]);
        }


        $eventBookingRequest = new EventBookingRequest();
        $eventBooking = new EventBooking($request->validate($eventBookingRequest->rules()));
        $eventBooking->ip_addr = $request->ip();
        $eventBooking->expire_at = Carbon::now()->add(CarbonInterval::make('15minutes'));

        $eventBooking->save();
        $eventBooking->refresh();

        $timeSlot = EventTimeSlot::find($eventBooking->event_time_slot_id);

        if($timeSlot->remaining_capacity < $attendeesRegCount) {
            $this->throwAttendeesCountValidationError($timeSlot->remaining_capacity);
        }

        DB::transaction(function () use ($eventBooking, $attendees, $timeSlot) {
            for ($i = 0; $i < $attendees["attendeesCount"]; $i++) {

                $eam = new EventAttendee();
                $eam->event_booking_id = $eventBooking->id;
                $eam->note = $attendees["attendeeNote"][$i];
                $eam->save();
            }

            if($timeSlot->attendees()->count() > $timeSlot->capacity) {
                $this->throwAttendeesCountValidationError($timeSlot->remaining_capacity);
            }
        });

        return redirect()->route("booking.show", $eventBooking->uuid)
            ->banner("Rezervace úspěšně vytvořena");

    }

    public function show(Request $request) {

        $bookingUUID = null;

        if(Str::isUuid($request->booking)) {
            $bookingUUID = $request->booking;
//        } else if($request->session()->get("booking_uuid") !== null) {
//            $bookingUUID = $request->session()->get("booking_uuid");
//            $bookingID = $request->booking;
        } else {
            abort(404);
        }

        $eventBooking = EventBooking::where("uuid", $bookingUUID)->with("eventTimeSlot", "eventTimeSlot.event", "userInfo")->firstOrFail();

        $this->authorize('view', $eventBooking);

        return inertia("EventBooking/Show", ["booking" => $eventBooking]);
    }

    public function update(EventBookingRequest $request, EventBooking $eventBooking) {
        $this->authorize('update', $eventBooking);

        $eventBooking->update($request->validated());

        return $eventBooking;
    }

    public function destroy(string $booking_uuid) {
        $eventBooking = EventBooking::where("uuid", $booking_uuid)->firstOrFail();

        $this->authorize('delete', $eventBooking);

        $eventBooking->delete();

        return redirect()->route("events.index")->banner("Vaše rezervace byla úspěšně zrušena");
    }

    /**
     * @param int $remainingCapacity
     * @return mixed
     */
    private function throwAttendeesCountValidationError(int $remainingCapacity) {
        throw ValidationException::withMessages([
            'attendeesCount' => ["Event time slot has only " . $remainingCapacity . " remaining capacity"]
        ]);
    }

    public function cleanup() {
        return EventBooking::where("expire_at", "<", Carbon::now())->delete();
    }
}
