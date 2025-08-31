<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingInfoRequest;
use App\Models\UserInfo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingInfoController extends Controller {
    use AuthorizesRequests;

    public function index() {
        $this->authorize('viewAny', UserInfo::class);

        return UserInfo::all();
    }

    public function store(BookingInfoRequest $request) {
        $this->authorize('create', UserInfo::class);

        return UserInfo::create($request->validated());
    }

    public function show(UserInfo $bookingInfo) {
        $this->authorize('view', $bookingInfo);

        return $bookingInfo;
    }

    public function update(BookingInfoRequest $request, UserInfo $bookingInfo) {
        $this->authorize('update', $bookingInfo);

        $bookingInfo->update($request->validated());

        return $bookingInfo;
    }

    public function destroy(UserInfo $bookingInfo) {
        $this->authorize('delete', $bookingInfo);

        $bookingInfo->delete();

        return response()->json();
    }
}
