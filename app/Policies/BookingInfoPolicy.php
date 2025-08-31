<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingInfoPolicy {
    use HandlesAuthorization;

    public function viewAny(?User $user): bool {
        return true;
    }

    public function view(?User $user, UserInfo $bookingInfo): bool {
        return true;
    }

    public function create(?User $user): bool {
        return true;
    }

    public function update(?User $user, UserInfo $bookingInfo): bool {
        return true;
    }

    public function delete(?User $user, UserInfo $bookingInfo): bool {
        return true;
    }

    public function restore(?User $user, UserInfo $bookingInfo): bool {
        return true;
    }

    public function forceDelete(?User $user, UserInfo $bookingInfo): bool {
        return true;
    }
}
