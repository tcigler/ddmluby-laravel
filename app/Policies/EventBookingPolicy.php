<?php

namespace App\Policies;

use App\Models\EventBooking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventBookingPolicy {
    use HandlesAuthorization;

    public function viewAny(?User $user): bool {
        return true;


    }

    public function view(?User $user, EventBooking $eventBooking): bool {
        return true;
    }

    public function create(?User $user): bool {
        return true;
    }

    public function update(?User $user, EventBooking $eventBooking): bool {
        return true;
    }

    public function delete(?User $user, EventBooking $eventBooking): bool {
        return true;
    }

    public function restore(?User $user, EventBooking $eventBooking): bool {
        return true;
    }

    public function forceDelete(?User $user, EventBooking $eventBooking): bool {
        return true;
    }
}
