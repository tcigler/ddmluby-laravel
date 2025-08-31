<?php

namespace App\Policies;

use App\Models\EventTimeSlot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventTimeSlotPolicy {
    use HandlesAuthorization;

    public function viewAny(?User $user): bool {
        return true;
    }

    public function view(?User $user, EventTimeSlot $eventTimeSlot): bool {
        return true;
    }

    public function create(?User $user): bool {
        return true;
    }

    public function update(?User $user, EventTimeSlot $eventTimeSlot): bool {
        return true;
    }

    public function delete(?User $user, EventTimeSlot $eventTimeSlot): bool {
        return true;
    }

    public function restore(?User $user, EventTimeSlot $eventTimeSlot): bool {
        return true;
    }

    public function forceDelete(?User $user, EventTimeSlot $eventTimeSlot): bool {
        return true;
    }
}
