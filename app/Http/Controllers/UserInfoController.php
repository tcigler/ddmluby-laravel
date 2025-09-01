<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
use App\Mail\UserVerificationMail;
use App\Models\EventBooking;
use App\Models\UserInfo;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserInfoController extends Controller {
    use AuthorizesRequests;

    public function index() {
        $this->authorize('viewAny', UserInfo::class);

        return UserInfo::all();
    }

    public function create(Request $request) {
        $booking = EventBooking::where("uuid", $request->booking_uuid)->firstOrFail();
        $this->authorize('view', $booking);

        return inertia("UserInfo/Create", ["booking_uuid" => $booking->uuid]);
    }

    public function store(UserInfoRequest $request) {
        $this->authorize('create', UserInfo::class);

        $booking = EventBooking::where("uuid", $request->booking_uuid)->firstOrFail();

        $userInfo = UserInfo::create($request->validated());
        $userInfo->save();

        $booking->user_info_id = $userInfo->id;
        $booking->expire_at = Carbon::now()->add(CarbonInterval::make('1 hour'));
        $booking->save();

        Mail::to($userInfo->email)->send(new UserVerificationMail($booking->event, $userInfo, $booking, $booking->eventTimeSlot));

        return redirect()->route("booking.show", $booking->uuid)
            ->banner("Osobní údaje úspěšně uloženy a potvrzovací e-mail poslán na zadanou adresu");
    }

    public function show(UserInfo $bookingInfo) {
        $this->authorize('view', $bookingInfo);

        return $bookingInfo;
    }

    public function edit(UserInfo $userInfo, Request $request) {
        $this->authorizeEdit($userInfo, $request);

        return inertia("UserInfo/Edit",
            [
                "user_info" => $userInfo,
                "booking_uuid" => $request->booking_uuid
            ]);
    }

    public function update(UserInfoRequest $request, UserInfo $userInfo) {
        $this->authorizeEdit($userInfo, $request);

        $userInfo->update($request->validated());

//        $booking = EventBooking::where("uuid", $request->booking_uuid)->firstOrFail();
//        Mail::to($userInfo->email)->send(new UserVerificationMail($booking->event, $userInfo, $booking, $booking->eventTimeSlot));

        return redirect()->route("booking.show", $request->booking_uuid);
    }

    public function destroy(UserInfo $bookingInfo) {
        $this->authorize('delete', $bookingInfo);

        $bookingInfo->delete();

        return response()->json();
    }

    /**
     * @param UserInfo $userInfo
     * @param Request $request
     * @return void
     */
    private function authorizeEdit(UserInfo $userInfo, Request $request): void {
        $this->authorize('update', $userInfo);

        $booking = EventBooking::where("uuid", $request->booking_uuid)->firstOrFail();
        $this->authorize('update', $booking);

        if ($userInfo->id != $booking->user_info_id) {
            abort(403);
        }
    }

    public function confirm(UserInfo $userInfo, Request $request) {
//        $booking = $userInfo->eventBooking;
        $this->authorize('update', $userInfo);
        if ($request->code == $userInfo->verification_code) {
            $userInfo->verification_code = null;
            $userInfo->verified_at = Carbon::now();
            $userInfo->save();

            $booking = $userInfo->eventBooking;
            $booking->expire_at = null;
            $booking->save();

            return redirect()->route("booking.show", $booking->uuid)
                ->banner("Registrace úspešně potvrzena!");
        } else {
            abort(404);
        }
    }
}
