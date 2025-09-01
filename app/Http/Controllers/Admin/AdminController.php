<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserVerificationMail;
use App\Models\Booking;
use App\Models\Event;
use App\Models\EventBooking;
use App\Models\EventTimeSlot;
use App\Models\Tour;
use App\Models\UserInfo;
use Inertia\Inertia;

class AdminController extends Controller {
    public function index() {
        return Inertia::render("Admin/Index");
    }

    public function previewMail() {
        $userInfo = UserInfo::first(); // or factory/fake data

        return new UserVerificationMail(Event::first(), $userInfo, EventBooking::first(), EventTimeSlot::first());
    }


}
