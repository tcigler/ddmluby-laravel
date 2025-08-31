<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
use App\Models\EventBooking;
use App\Models\UserInfo;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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

        return redirect()->route("booking.show", $booking->uuid)
            ->banner("Osobní údaje úspěšně uloženy");
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
}
