<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class EventTimeSlot extends Model {
    use HasFactory;

    protected $appends = ['remaining_capacity'];

    // Always load attendees_count
    protected $withCount = ['attendees'];

    protected $fillable = [
        'event_id',
        'time',
        'capacity',
        'blocked',
    ];

    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }

    public function bookings(): HasMany {
        return $this->hasMany(EventBooking::class);
    }

    public function attendees(): HasManyThrough {
        return $this->hasManyThrough(EventAttendee::class, EventBooking::class);
    }

    public function getRemainingCapacityAttribute(): int {
        // use preloaded attendees_count (from $withCount)
        $booked = $this->attendees_count ?? 0;
        return max(0, $this->capacity - $booked);
    }

    public function scopeWithRemaining($query) {
        return $query->havingRaw('capacity - attendees_count > 0');
    }

    protected function casts(): array {
        return [
            'time' => 'datetime',
            'blocked' => 'boolean',
        ];
    }
}
